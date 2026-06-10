<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Filament\Actions\Action;

class DatabaseBackup extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-circle-stack';
    protected static ?string $navigationLabel = 'Pencadangan Database';
    protected static ?string $title = 'Pencadangan Database';
    protected static ?string $slug = 'database-backup';
    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?int $navigationSort = 100;

    protected static string $view = 'filament.pages.database-backup';

    /**
     * Only show this page for superadmin users.
     */
    public static function canAccess(): bool
    {
        return Auth::check() && Auth::user()->role === 'superadmin';
    }

    public function mount(): void
    {
        // Ensure backup directory exists
        if (!file_exists(storage_path('app/backups'))) {
            mkdir(storage_path('app/backups'), 0755, true);
        }
    }

    public function createBackup(): void
    {
        if (Auth::user()->role !== 'superadmin') {
            abort(403);
        }

        try {
            $dbName = Config::get('database.connections.mysql.database');
            $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
            $filename  = "backup_{$dbName}_{$timestamp}.sql";
            $filePath  = storage_path("app/backups/{$filename}");

            // Generate SQL Backup using pure PHP
            $this->generateSqlBackup($filePath, $dbName);

            // Verify file was created and has content
            if (!file_exists($filePath) || filesize($filePath) === 0) {
                throw new \Exception('File backup kosong atau tidak berhasil dibuat.');
            }

            Notification::make()
                ->success()
                ->title('Pencadangan Berhasil')
                ->body("Berkas: {$filename} (" . $this->formatFileSize(filesize($filePath)) . ")")
                ->duration(8000)
                ->send();

        } catch (\Exception $e) {
            // Clean up failed backup file
            if (isset($filePath) && file_exists($filePath)) {
                unlink($filePath);
            }

            Notification::make()
                ->danger()
                ->title('Pencadangan Gagal')
                ->body($e->getMessage())
                ->duration(10000)
                ->send();
        }
    }

    private function generateSqlBackup(string $filePath, string $dbName): void
    {
        // Ensure the directory exists
        $dir = dirname($filePath);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $handle = fopen($filePath, 'w+');
        if (!$handle) {
            throw new \Exception('Tidak dapat membuat file backup di direktori storage/app/backups.');
        }

        fwrite($handle, "/* Backup Database (PHP Generated) */\n");
        fwrite($handle, "/* Waktu: " . Carbon::now()->format('Y-m-d H:i:s') . " */\n");
        fwrite($handle, "/* Database: {$dbName} */\n\n");
        
        fwrite($handle, "SET FOREIGN_KEY_CHECKS=0;\n\n");

        $tables = \Illuminate\Support\Facades\DB::select('SHOW TABLES');
        
        foreach ($tables as $tableItem) {
            // Get table name safely regardless of DB fetch format
            $tableName = array_values((array)$tableItem)[0];

            // Get Create Table Statement
            $createTable = \Illuminate\Support\Facades\DB::select("SHOW CREATE TABLE `{$tableName}`");
            $createTableSql = array_values((array)$createTable[0])[1]; // [0] -> Table, [1] -> Create Table String

            fwrite($handle, "-- --------------------------------------------------------\n");
            fwrite($handle, "-- Struktur dari tabel `{$tableName}`\n");
            fwrite($handle, "-- --------------------------------------------------------\n\n");
            fwrite($handle, "DROP TABLE IF EXISTS `{$tableName}`;\n");
            fwrite($handle, $createTableSql . ";\n\n");

            // Get Data using cursor to prevent memory exhaustion and avoid orderBy errors
            fwrite($handle, "-- Data untuk tabel `{$tableName}`\n\n");
            
            $rows = \Illuminate\Support\Facades\DB::table($tableName)->cursor();
            $hasData = false;
            $columnsStr = '';
            
            foreach ($rows as $row) {
                if (!$hasData) {
                    $firstRow = (array) $row;
                    $columns = array_keys($firstRow);
                    $columnsStr = implode("`, `", $columns);
                    $hasData = true;
                }
                
                $rowArray = (array) $row;
                $values = [];
                $pdo = \Illuminate\Support\Facades\DB::connection()->getPdo();
                foreach ($rowArray as $value) {
                    if ($value === null) {
                        $values[] = "NULL";
                    } else {
                        $values[] = $pdo->quote((string)$value);
                    }
                }
                
                $valuesStr = implode(", ", $values);
                fwrite($handle, "INSERT INTO `{$tableName}` (`{$columnsStr}`) VALUES ({$valuesStr});\n");
            }
            if ($hasData) {
                fwrite($handle, "\n");
            }
        }
        
        fwrite($handle, "SET FOREIGN_KEY_CHECKS=1;\n");
        fclose($handle);
    }

    public function downloadBackup(string $filename)
    {
        if (Auth::user()->role !== 'superadmin') {
            abort(403);
        }

        $path = storage_path("app/backups/{$filename}");

        if (!file_exists($path)) {
            Notification::make()
                ->danger()
                ->title('File tidak ditemukan')
                ->body($filename)
                ->send();
            return;
        }

        return response()->download($path, $filename, [
            'Content-Type' => 'application/sql',
        ]);
    }

    public function deleteBackupFile(string $filename): void
    {
        if (Auth::user()->role !== 'superadmin') {
            abort(403);
        }

        $path = storage_path("app/backups/{$filename}");

        if (file_exists($path)) {
            unlink($path);

            Notification::make()
                ->success()
                ->title('Cadangan Dihapus')
                ->body("Berkas '{$filename}' berhasil dihapus.")
                ->send();
        } else {
            Notification::make()
                ->danger()
                ->title('File tidak ditemukan')
                ->body($filename)
                ->send();
        }
    }

    public function getBackups(): array
    {
        $backupDir = storage_path('app/backups');

        if (!is_dir($backupDir)) {
            return [];
        }

        $files = glob($backupDir . '/*.sql');
        $backups = [];

        foreach ($files as $file) {
            $filename = basename($file);
            $backups[] = [
                'name'       => $filename,
                'size'       => $this->formatFileSize(filesize($file)),
                'size_raw'   => filesize($file),
                'created_at' => Carbon::createFromTimestamp(filemtime($file))->format('d M Y, H:i:s'),
                'timestamp'  => filemtime($file),
            ];
        }

        // Sort newest first
        usort($backups, fn($a, $b) => $b['timestamp'] <=> $a['timestamp']);

        return $backups;
    }

    private function formatFileSize(int $bytes): string
    {
        if ($bytes >= 1073741824) return number_format($bytes / 1073741824, 2) . ' GB';
        if ($bytes >= 1048576) return number_format($bytes / 1048576, 2) . ' MB';
        if ($bytes >= 1024) return number_format($bytes / 1024, 2) . ' KB';
        return $bytes . ' B';
    }

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function getActions(): array
    {
        return [
            Action::make('deleteBackup')
                ->requiresConfirmation()
                ->modalHeading('Hapus Cadangan Database')
                ->modalDescription(fn (array $arguments) => "Yakin ingin menghapus cadangan " . ($arguments['name'] ?? '') . "? Tindakan ini tidak dapat dibatalkan.")
                ->modalSubmitActionLabel('Hapus')
                ->modalCancelActionLabel('Batal')
                ->color('danger')
                ->action(fn (array $arguments) => $this->deleteBackupFile($arguments['name'] ?? '')),
        ];
    }
}
