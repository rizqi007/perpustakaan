<?php

namespace App\Imports;

use App\Models\KlipingDigital;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;

class KlipingDigitalImport implements ToModel, WithHeadingRow, WithCustomCsvSettings
{
    protected $headingRow;
    protected $delimiter;

    public function __construct($headingRow = 2, $delimiter = ';')
    {
        $this->headingRow = $headingRow;
        $this->delimiter = $delimiter;
    }

    /**
     * Set the heading row.
     */
    public function headingRow(): int
    {
        return $this->headingRow;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public static $log = [];
    
    public function model(array $row)
    {
        // Handle truncated headers or variations
        $title = $row['judul_artikel'] ?? $row['judul_artik'] ?? $row['judul'] ?? null;

        // Debug or strict check
        if (!$title) {
            // Check if there is actual content in the other major fields to verify if it is a real data row
            $hasContent = false;
            foreach (['penulis', 'media', 'rubrik'] as $key) {
                if (isset($row[$key]) && trim($row[$key]) !== '' && trim($row[$key]) !== '-') {
                    $hasContent = true;
                    break;
                }
            }
            
            // Only log warning if it is a real row that was misfilled, not blank spreadsheet template rows
            if ($hasContent) {
                self::$log[] = "Baris ke-" . ($row['no'] ?? '?') . " dilewati: Kolom judul kosong tetapi memiliki data penulis/media.";
            }
            return null;
        }

        $tanggalRaw = $row['tanggal'] ?? null;
        $publishedAt = null;

        if ($tanggalRaw) {
            // Case 1: Already a DateTime/Carbon object
            if ($tanggalRaw instanceof \DateTimeInterface) {
                $publishedAt = \Carbon\Carbon::instance($tanggalRaw);
            }
            // Case 2: Numeric Excel serial number (usually > 1000, e.g., 46166)
            elseif (is_numeric($tanggalRaw) && floatval($tanggalRaw) > 1000) {
                try {
                    $dateTimeObj = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($tanggalRaw);
                    $publishedAt = \Carbon\Carbon::instance($dateTimeObj);
                } catch (\Exception $e) {
                    $publishedAt = null;
                }
            }
            // Case 3: A string containing a full date (e.g. "25-5-2026", "2026-05-25", "25/05/2026")
            elseif (is_string($tanggalRaw) && (str_contains($tanggalRaw, '-') || str_contains($tanggalRaw, '/'))) {
                try {
                    // Try to parse using Carbon
                    $publishedAt = \Carbon\Carbon::parse(str_replace('/', '-', $tanggalRaw));
                } catch (\Exception $e) {
                    // Fallback to regex or manual parsing for formats like "d-m-Y"
                    $parts = preg_split('/[-|\/]/', $tanggalRaw);
                    if (count($parts) === 3) {
                        $p0 = intval($parts[0]);
                        $p1 = intval($parts[1]);
                        $p2 = intval($parts[2]);
                        
                        // Check if it is d-m-Y or Y-m-d
                        if ($p0 > 31) { // Y-m-d
                            $tahun = $p0;
                            $bulan = $p1;
                            $tanggal = $p2;
                        } else { // d-m-Y
                            $tanggal = $p0;
                            $bulan = $p1;
                            $tahun = $p2;
                        }
                        
                        try {
                            $publishedAt = \Carbon\Carbon::createFromDate($tahun, $bulan, $tanggal);
                        } catch (\Exception $ex) {
                            $publishedAt = null;
                        }
                    }
                }
            }
        }

        // Fallback: If it's not a full date in the Tanggal column, use the old day + month + year logic!
        if (!$publishedAt) {
            $tanggal = intval($row['tanggal'] ?? 1);
            if ($tanggal < 1 || $tanggal > 31) {
                $tanggal = 1;
            }

            $bulanStr = trim($row['bulan'] ?? 'Januari');
            $bulanMap = [
                'Januari' => 1, 'Februari' => 2, 'Maret' => 3, 'April' => 4,
                'Mei' => 5, 'Juni' => 6, 'Juli' => 7, 'Agustus' => 8,
                'September' => 9, 'Oktober' => 10, 'November' => 11, 'Desember' => 12,
                'Jan' => 1, 'Feb' => 2, 'Mar' => 3, 'Apr' => 4,
                'May' => 5, 'Jun' => 6, 'Jul' => 7, 'Aug' => 8,
                'Sep' => 9, 'Oct' => 10, 'Nov' => 11, 'Dec' => 12,
            ];
            $bulan = $bulanMap[$bulanStr] ?? 1;

            $tahunInput = trim($row['tahun'] ?? date('Y'));
            $tahun = intval($tahunInput);
            if ($tahun < 1900 || $tahun > 2100) {
                if (strlen($tahunInput) >= 4) {
                    $tahun = intval(substr($tahunInput, 0, 4));
                } else {
                    $tahun = date('Y');
                }
            }
            if ($tahun < 1900 || $tahun > 2100) {
                $tahun = date('Y');
            }

            try {
                $publishedAt = \Carbon\Carbon::createFromDate($tahun, $bulan, $tanggal);
            } catch (\Exception $e) {
                $publishedAt = now();
            }
        }

        // Find existing record by Title (and optionally Author/Source to be more specific)
        $kliping = KlipingDigital::where('title', $title)->first();

        if ($kliping) {
            $kliping->update([
                'author' => $row['penulis'] ?? $kliping->author,
                'source' => $row['media'] ?? $kliping->source,
                'topic' => $row['rubrik'] ?? $kliping->topic,
                'page_number' => $row['halaman'] ?? $kliping->page_number,
                'published_at' => $publishedAt,
            ]);
            
            return $kliping;
        }

        return new KlipingDigital([
            'title' => $title,
            'author' => $row['penulis'] ?? '-',
            'source' => $row['media'] ?? '-',
            'topic' => $row['rubrik'] ?? null,
            'page_number' => $row['halaman'] ?? null,
            'published_at' => $publishedAt,
        ]);
    }
    
    public function getCsvSettings(): array
    {
        return [
            'input_encoding' => 'UTF-8',
            'delimiter' => $this->delimiter,
        ];
    }
}
