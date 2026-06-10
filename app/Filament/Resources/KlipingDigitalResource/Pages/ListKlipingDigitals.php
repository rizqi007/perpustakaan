<?php

namespace App\Filament\Resources\KlipingDigitalResource\Pages;

use App\Filament\Resources\KlipingDigitalResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Imports\KlipingDigitalImport;
use App\Models\KlipingDigital;

// 1. Memory-efficient Read Filter for scanning headers (only loads rows 1 to 5)
class HeaderReadFilter implements \PhpOffice\PhpSpreadsheet\Reader\IReadFilter
{
    public function readCell($columnAddress, $row, $worksheetName = '')
    {
        return $row <= 5;
    }
}

// 2. Memory-efficient Read Filter for chunk loading (only loads active chunk rows + header row)
class ChunkReadFilter implements \PhpOffice\PhpSpreadsheet\Reader\IReadFilter
{
    private int $startRow;
    private int $endRow;
    private int $headerRow;

    public function __construct(int $startRow, int $chunkSize, int $headerRow = 2)
    {
        $this->startRow = $startRow;
        $this->endRow = $startRow + $chunkSize;
        $this->headerRow = $headerRow;
    }

    public function readCell($columnAddress, $row, $worksheetName = '')
    {
        return $row === $this->headerRow || ($row >= $this->startRow && $row <= $this->endRow);
    }
}

class ListKlipingDigitals extends ListRecords
{
    protected static string $resource = KlipingDigitalResource::class;

    protected static string $view = 'filament.resources.kliping-digital.list';

    // State properties for chunked background synchronization
    public bool $isSyncing = false;
    public string $tempFilePath = '';
    public int $totalRows = 0;
    public int $processedRows = 0;
    public int $syncPercentage = 0;
    public array $syncSheetsData = [];

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    /**
     * Start the synchronization process asynchronously with maximum memory efficiency.
     */
    public function startSync(string $url, bool $clearExisting): void
    {
        try {
            // Fetch spreadsheet content without verifying SSL
            $response = Http::withoutVerifying()->get($url);
            if (!$response->successful()) {
                throw new \Exception("Gagal mengunduh Google Sheet. Pastikan URL benar dan telah dipublikasikan ke web.");
            }
            
            $fileContent = $response->body();
            
            // Save temporarily
            $tempName = uniqid() . '_google_sheet.xlsx';
            $tempPath = 'temp/' . $tempName;
            Storage::disk('local')->put($tempPath, $fileContent);
            $this->tempFilePath = Storage::disk('local')->path($tempPath);
            
            if ($clearExisting) {
                KlipingDigital::truncate();
            }
            
            // Open using PhpSpreadsheet to scan sheets and calculate rows without loading cell data (instant)
            $reader = IOFactory::createReaderForFile($this->tempFilePath);
            $sheetNames = $reader->listWorksheetNames($this->tempFilePath);
            
            // Get worksheet info containing row counts without loading worksheets in memory (memory safe)
            $worksheetInfo = $reader->listWorksheetInfo($this->tempFilePath);
            $rowsInfoMap = [];
            foreach ($worksheetInfo as $info) {
                $rowsInfoMap[$info['worksheetName']] = $info['totalRows'];
            }
            
            $this->syncSheetsData = [];
            $this->totalRows = 0;
            $this->processedRows = 0;
            $this->syncPercentage = 0;
            
            foreach ($sheetNames as $index => $name) {
                // Only load first 5 rows to detect headers (extremely memory efficient)
                $headerReader = IOFactory::createReaderForFile($this->tempFilePath);
                $headerReader->setReadDataOnly(true);
                $headerReader->setLoadSheetsOnly($name);
                $headerReader->setReadFilter(new HeaderReadFilter());
                
                $spreadsheet = $headerReader->load($this->tempFilePath);
                $worksheet = $spreadsheet->getSheet(0); // Index 0 as only one sheet is loaded
                
                // Get the total row count from worksheet info map
                $highestRow = $rowsInfoMap[$name] ?? $worksheet->getHighestRow();
                
                // Scan rows 1 to 5 to detect header row
                $detectedHeaderRow = 2;
                for ($rowNum = 1; $rowNum <= 5; $rowNum++) {
                    $rowCells = [];
                    $rowIterator = $worksheet->getRowIterator($rowNum, $rowNum);
                    if ($rowIterator->valid()) {
                        foreach ($rowIterator->current()->getCellIterator() as $cell) {
                            $rowCells[] = $cell->getValue();
                        }
                    }
                    
                    $hasHeaderKeywords = false;
                    foreach ($rowCells as $val) {
                        if (is_string($val) && (
                            stripos($val, 'Tanggal') !== false || 
                            stripos($val, 'Judul') !== false || 
                            stripos($val, 'Penulis') !== false ||
                            stripos($val, 'Media') !== false
                        )) {
                            $hasHeaderKeywords = true;
                            break;
                        }
                    }
                    
                    if ($hasHeaderKeywords) {
                        $detectedHeaderRow = $rowNum;
                        break;
                    }
                }
                
                // Read headers from detected header row
                $headers = [];
                $rowIterator = $worksheet->getRowIterator($detectedHeaderRow, $detectedHeaderRow);
                if ($rowIterator->valid()) {
                    foreach ($rowIterator->current()->getCellIterator() as $cell) {
                        $headers[] = $this->normalizeHeader($cell->getValue());
                    }
                }
                
                // Estimate rows count below header to avoid scanning thousands of rows in startSync
                $sheetRowsCount = max(0, $highestRow - $detectedHeaderRow);
                
                if ($sheetRowsCount > 0) {
                    $this->syncSheetsData[] = [
                        'sheetIndex' => $index,
                        'sheetName' => $name,
                        'headerRow' => $detectedHeaderRow,
                        'headers' => $headers,
                        'currentRow' => $detectedHeaderRow + 1,
                        'highestRow' => $highestRow,
                        'rowsCount' => $sheetRowsCount,
                    ];
                    
                    $this->totalRows += $sheetRowsCount;
                }
            }
            
            if ($this->totalRows === 0) {
                throw new \Exception("Tidak ada data kliping yang ditemukan di Google Sheet tersebut.");
            }
            
            $this->isSyncing = true;
            
        } catch (\Exception $e) {
            $this->isSyncing = false;
            if ($this->tempFilePath && file_exists($this->tempFilePath)) {
                @unlink($this->tempFilePath);
            }
            
            \Filament\Notifications\Notification::make()
                ->title('Sinkronisasi Google Sheet Gagal')
                ->body($e->getMessage())
                ->danger()
                ->persistent()
                ->send();
        }
    }

    /**
     * Process the next chunk of rows during polling with extreme memory efficiency.
     */
    public function importNextChunk(): void
    {
        if (!$this->isSyncing) {
            return;
        }
        
        try {
            // Find the first sheet that still has rows left to process
            $activeSheetKey = null;
            foreach ($this->syncSheetsData as $key => $sheetInfo) {
                if ($sheetInfo['currentRow'] <= $sheetInfo['highestRow']) {
                    $activeSheetKey = $key;
                    break;
                }
            }
            
            if ($activeSheetKey === null) {
                // Done with all sheets!
                $this->finishSync();
                return;
            }
            
            $sheetInfo = $this->syncSheetsData[$activeSheetKey];
            $currentRow = $sheetInfo['currentRow'];
            $highestRow = $sheetInfo['highestRow'];
            $headers = $sheetInfo['headers'];
            
            $chunkSize = 30; // 30 rows per chunk is optimal
            
            // Open sheet using PhpSpreadsheet (Read Data Only, Single Sheet, Custom Row Filter for absolute memory safety)
            $reader = IOFactory::createReaderForFile($this->tempFilePath);
            $reader->setReadDataOnly(true);
            $reader->setLoadSheetsOnly($sheetInfo['sheetName']);
            $reader->setReadFilter(new ChunkReadFilter($currentRow, $chunkSize, $sheetInfo['headerRow']));
            
            $spreadsheet = $reader->load($this->tempFilePath);
            $worksheet = $spreadsheet->getSheet(0); // Index 0 as only one sheet is loaded
            
            $rowsProcessedThisChunk = 0;
            
            // Instantiate helper importer
            $importer = new KlipingDigitalImport($sheetInfo['headerRow']);
            
            $worksheetHighestRow = $worksheet->getHighestRow();
            
            while ($rowsProcessedThisChunk < $chunkSize && $currentRow <= $highestRow) {
                // If the current row exceeds the actual physical highest row loaded in the worksheet
                if ($currentRow > $worksheetHighestRow) {
                    $remainingRows = max(0, $highestRow - $currentRow + 1);
                    $this->processedRows += $remainingRows;
                    
                    $currentRow = $highestRow + 1; // Force end of this sheet's loop
                    break;
                }

                $rowCells = [];
                $rowIterator = $worksheet->getRowIterator($currentRow, $currentRow);
                if ($rowIterator->valid()) {
                    foreach ($rowIterator->current()->getCellIterator() as $cell) {
                        $rowCells[] = $cell->getValue();
                    }
                }
                
                // Build associative row array
                $row = [];
                $hasContent = false;
                foreach ($headers as $colIndex => $headerName) {
                    if (empty($headerName)) {
                        continue;
                    }
                    $val = $rowCells[$colIndex] ?? null;
                    $row[$headerName] = $val;
                    if ($val !== null && trim((string)$val) !== '') {
                        $hasContent = true;
                    }
                }
                
                if ($hasContent) {
                    $modelInstance = $importer->model($row);
                    // Explicitly save the model if it is a new instance (as model() only instantiates it)
                    if ($modelInstance instanceof \Illuminate\Database\Eloquent\Model && !$modelInstance->exists) {
                        $modelInstance->save();
                    }
                }
                
                $this->processedRows++;
                $rowsProcessedThisChunk++;
                $currentRow++;
            }
            
            // Update the sheet progress state
            $this->syncSheetsData[$activeSheetKey]['currentRow'] = $currentRow;
            
            // Calculate current progress percentage
            if ($this->totalRows > 0) {
                $this->syncPercentage = min(100, intval(($this->processedRows / $this->totalRows) * 100));
            }
            
        } catch (\Exception $e) {
            $this->isSyncing = false;
            if ($this->tempFilePath && file_exists($this->tempFilePath)) {
                @unlink($this->tempFilePath);
            }
            
            \Filament\Notifications\Notification::make()
                ->title('Sinkronisasi Gagal Saat Memproses Data')
                ->body($e->getMessage())
                ->danger()
                ->persistent()
                ->send();
        }
    }

    /**
     * Finalize the synchronization process.
     */
    protected function finishSync(): void
    {
        $this->isSyncing = false;
        
        if ($this->tempFilePath && file_exists($this->tempFilePath)) {
            @unlink($this->tempFilePath);
        }
        
        \Filament\Notifications\Notification::make()
            ->title('Sinkronisasi Google Sheet Selesai')
            ->body("Berhasil sinkronisasi {$this->processedRows} baris dari Google Sheet!")
            ->success()
            ->send();
            
        // Check for skipped rows in KlipingDigitalImport::$log
        if (!empty(KlipingDigitalImport::$log)) {
            $logs = array_slice(KlipingDigitalImport::$log, 0, 5);
            $totalSkipped = count(KlipingDigitalImport::$log);
            
            $advice = "";
            $firstLog = $logs[0] ?? '';
            if (str_contains($firstLog, 'Keys found [1, 2, januari') || str_contains($firstLog, 'Keys found [1, 2, 3')) {
                $advice = "\n\n**Solusi:** Sistem mendeteksi data sebagai header. Periksa baris header pada Google Sheet Anda.";
            }
            
            \Filament\Notifications\Notification::make()
                ->title("Perhatian: {$totalSkipped} Baris Dilewati")
                ->body(implode("\n", $logs) . ($totalSkipped > 5 ? "\n...dan baris lainnya." : "") . $advice)
                ->warning()
                ->persistent()
                ->send();
        }
    }

    /**
     * Normalize heading row cells.
     */
    protected function normalizeHeader(?string $header): string
    {
        if (empty($header)) {
            return '';
        }
        $header = strtolower(trim($header));
        $header = str_replace([' ', '-', '/'], '_', $header);
        return preg_replace('/[^a-z0-9_]/', '', $header);
    }
}
