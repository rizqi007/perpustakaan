<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Carbon\Carbon;

class DatabaseBackup extends Component
{
    public bool $isBackingUp = false;
    public string $backupMessage = '';
    public string $backupMessageType = ''; // success, error
    public bool $showDeleteModal = false;
    public string $deleteFileName = '';

    public function mount()
    {
        // Only superadmin can access
        if (Auth::user()->role !== 'superadmin') {
            abort(403, 'Unauthorized');
        }

        // Ensure backup directory exists
        if (!Storage::disk('local')->exists('backups')) {
            Storage::disk('local')->makeDirectory('backups');
        }
    }

    public function createBackup()
    {
        if (Auth::user()->role !== 'superadmin') {
            abort(403);
        }

        $this->isBackingUp = true;
        $this->backupMessage = '';

        try {
            $dbHost     = Config::get('database.connections.mysql.host');
            $dbPort     = Config::get('database.connections.mysql.port', '3306');
            $dbName     = Config::get('database.connections.mysql.database');
            $dbUser     = Config::get('database.connections.mysql.username');
            $dbPassword = Config::get('database.connections.mysql.password');

            $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
            $filename  = "backup_{$dbName}_{$timestamp}.sql";
            $filePath  = storage_path("app/backups/{$filename}");

            // Build mysqldump command
            $command = sprintf(
                'mysqldump --host=%s --port=%s --user=%s %s %s > %s 2>&1',
                escapeshellarg($dbHost),
                escapeshellarg($dbPort),
                escapeshellarg($dbUser),
                $dbPassword ? '--password=' . escapeshellarg($dbPassword) : '',
                escapeshellarg($dbName),
                escapeshellarg($filePath)
            );

            $output = [];
            $exitCode = 0;
            exec($command, $output, $exitCode);

            if ($exitCode !== 0) {
                $errorMsg = implode("\n", $output);
                throw new \Exception("mysqldump gagal (exit code: {$exitCode}): {$errorMsg}");
            }

            // Verify file was created and has content
            if (!file_exists($filePath) || filesize($filePath) === 0) {
                throw new \Exception('File backup kosong atau tidak berhasil dibuat.');
            }

            $this->backupMessage = "Backup berhasil dibuat: {$filename} (" . $this->formatFileSize(filesize($filePath)) . ")";
            $this->backupMessageType = 'success';

        } catch (\Exception $e) {
            $this->backupMessage = "Gagal membuat backup: " . $e->getMessage();
            $this->backupMessageType = 'error';

            // Clean up failed backup file
            if (isset($filePath) && file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $this->isBackingUp = false;
    }

    public function downloadBackup(string $filename)
    {
        if (Auth::user()->role !== 'superadmin') {
            abort(403);
        }

        $path = storage_path("app/backups/{$filename}");

        if (!file_exists($path)) {
            $this->backupMessage = "File tidak ditemukan: {$filename}";
            $this->backupMessageType = 'error';
            return;
        }

        return response()->download($path, $filename, [
            'Content-Type' => 'application/sql',
        ]);
    }

    public function confirmDelete(string $filename)
    {
        $this->deleteFileName = $filename;
        $this->showDeleteModal = true;
    }

    public function cancelDelete()
    {
        $this->showDeleteModal = false;
        $this->deleteFileName = '';
    }

    public function deleteBackup()
    {
        if (Auth::user()->role !== 'superadmin') {
            abort(403);
        }

        $filename = $this->deleteFileName;
        $path = "backups/{$filename}";

        if (Storage::disk('local')->exists($path)) {
            Storage::disk('local')->delete($path);
            $this->backupMessage = "Backup '{$filename}' berhasil dihapus.";
            $this->backupMessageType = 'success';
        } else {
            $this->backupMessage = "File tidak ditemukan: {$filename}";
            $this->backupMessageType = 'error';
        }

        $this->showDeleteModal = false;
        $this->deleteFileName = '';
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

    public function render()
    {
        return view('livewire.admin.database-backup', [
            'backups'  => $this->getBackups(),
            'dbName'   => Config::get('database.connections.mysql.database'),
            'dbHost'   => Config::get('database.connections.mysql.host'),
        ])->layout('layouts.admin');
    }
}
