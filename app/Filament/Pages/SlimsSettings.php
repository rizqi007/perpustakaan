<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;

class SlimsSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-link';
    protected static ?string $navigationLabel = 'Integrasi SLiMS';
    protected static ?string $title = 'Pengaturan Integrasi SLiMS';
    protected static ?string $slug = 'slims-settings';
    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?int $navigationSort = 98;

    protected static string $view = 'filament.pages.slims-settings';

    public ?array $data = [];

    // Test connection states
    public $testStatus = null; // 'success', 'failed', or null
    public $testMessage = null;

    /**
     * Only show this page for admin or superadmin users.
     */
    public static function canAccess(): bool
    {
        return Auth::check() && in_array(Auth::user()->role, ['admin', 'superadmin']);
    }

    public function mount(): void
    {
        $this->form->fill([
            'slimsEnabled' => (bool) config('services.slims.enabled', false),
            'slimsUrl' => config('services.slims.base_url', ''),
            'slimsHost' => config('database.connections.slims.host', '127.0.0.1'),
            'slimsPort' => config('database.connections.slims.port', '3306'),
            'slimsDatabase' => config('database.connections.slims.database', 'slims'),
            'slimsUsername' => config('database.connections.slims.username', 'root'),
            'slimsPassword' => config('database.connections.slims.password', ''),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Status Integrasi')
                    ->description('Aktifkan untuk menyinkronkan data anggota secara otomatis saat disetujui.')
                    ->schema([
                        Toggle::make('slimsEnabled')
                            ->label('Status Integrasi Otomatis')
                            ->helperText('Jika aktif, pendaftaran anggota yang disetujui akan langsung tersinkron ke SLiMS.')
                            ->live(),
                        TextInput::make('slimsUrl')
                            ->label('URL Base Website SLiMS')
                            ->helperText('Contoh: http://103.219.251.170 atau https://perpustakaan.kemendagri.go.id. Digunakan untuk menarik foto anggota.')
                            ->placeholder('http://...')
                            ->url()
                            ->nullable(),
                    ]),

                Section::make('Kredensial Koneksi Database SLiMS')
                    ->description('Atur konfigurasi koneksi langsung ke server database SLiMS Anda.')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('slimsHost')
                                    ->label('Host Database SLiMS')
                                    ->placeholder('127.0.0.1')
                                    ->required()
                                    ->columnSpan(2),
                                TextInput::make('slimsPort')
                                    ->label('Port')
                                    ->placeholder('3306')
                                    ->required()
                                    ->numeric(),
                            ]),
                        TextInput::make('slimsDatabase')
                            ->label('Nama Database SLiMS')
                            ->placeholder('slims')
                            ->required(),
                        Grid::make(2)
                            ->schema([
                                TextInput::make('slimsUsername')
                                    ->label('Username Database')
                                    ->placeholder('root')
                                    ->required(),
                                TextInput::make('slimsPassword')
                                    ->label('Password Database')
                                    ->password()
                                    ->revealable()
                                    ->placeholder('••••••••'),
                            ]),
                    ]),
            ])
            ->statePath('data');
    }

    public function testConnection()
    {
        $formData = $this->form->getState();
        $this->testStatus = 'testing';
        $this->testMessage = null;

        try {
            // Temporarily define connection configuration in Laravel runtime
            config([
                'database.connections.slims_test' => [
                    'driver' => 'mysql',
                    'host' => $formData['slimsHost'],
                    'port' => $formData['slimsPort'],
                    'database' => $formData['slimsDatabase'],
                    'username' => $formData['slimsUsername'],
                    'password' => $formData['slimsPassword'] ?? '',
                    'charset' => 'utf8mb4',
                    'collation' => 'utf8mb4_unicode_ci',
                    'prefix' => '',
                    'prefix_indexes' => true,
                    'strict' => false,
                    'engine' => null,
                    'options' => [
                        \PDO::ATTR_TIMEOUT => 4, // 4 seconds timeout limit
                    ],
                ]
            ]);

            // Clear connection cache to force re-instantiation
            DB::purge('slims_test');

            // Attempt to get PDO instance
            DB::connection('slims_test')->getPdo();

            $this->testStatus = 'success';
            $this->testMessage = 'Koneksi ke database SLiMS berhasil!';

            Notification::make()
                ->success()
                ->title('Koneksi Sukses')
                ->body('Koneksi ke database SLiMS berhasil terhubung.')
                ->send();
        } catch (\Exception $e) {
            $this->testStatus = 'failed';
            $this->testMessage = 'Koneksi gagal: ' . $e->getMessage();

            Notification::make()
                ->danger()
                ->title('Koneksi Gagal')
                ->body('Koneksi ke database SLiMS gagal: ' . $e->getMessage())
                ->send();
        }
    }

    public function saveSettings()
    {
        $formData = $this->form->getState();

        $data = [
            'SLIMS_CONNECTION_ENABLED' => $formData['slimsEnabled'] ? 'true' : 'false',
            'SLIMS_BASE_URL' => $formData['slimsUrl'] ?? '',
            'DB_SLIMS_HOST' => $formData['slimsHost'],
            'DB_SLIMS_PORT' => $formData['slimsPort'],
            'DB_SLIMS_DATABASE' => $formData['slimsDatabase'],
            'DB_SLIMS_USERNAME' => $formData['slimsUsername'],
            'DB_SLIMS_PASSWORD' => $formData['slimsPassword'] ?? '',
        ];

        if ($this->updateEnvFile($data)) {
            Notification::make()
                ->success()
                ->title('Pengaturan Disimpan')
                ->body('Konfigurasi SLiMS berhasil diperbarui di file .env.')
                ->send();
        } else {
            Notification::make()
                ->danger()
                ->title('Gagal Menyimpan')
                ->body('Gagal memperbarui file .env. Pastikan server memiliki izin menulis.')
                ->send();
        }
    }

    protected function updateEnvFile(array $data)
    {
        $envPath = base_path('.env');
        if (!file_exists($envPath)) {
            return false;
        }

        try {
            $envContent = file_get_contents($envPath);

            foreach ($data as $key => $value) {
                // Match the key at the beginning of the line
                $pattern = "/^" . preg_quote($key, '/') . "=(.*)$/m";
                
                // Format value properly
                $formattedValue = $value;
                if (preg_match('/[\s#*]/', $value) || strpos($value, '=') !== false) {
                    $formattedValue = '"' . str_replace('"', '\\"', $value) . '"';
                }

                if (preg_match($pattern, $envContent)) {
                    $envContent = preg_replace($pattern, "{$key}={$formattedValue}", $envContent);
                } else {
                    $envContent .= "\n{$key}={$formattedValue}";
                }
            }

            file_put_contents($envPath, $envContent);

            // Clear Laravel configuration cache
            Artisan::call('config:clear');

            return true;
        } catch (\Exception $e) {
            Log::error("Failed to update .env file: " . $e->getMessage());
            return false;
        }
    }
}
