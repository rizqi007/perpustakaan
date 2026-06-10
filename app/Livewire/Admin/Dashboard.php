<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\IsbnSubmission;
use App\Models\Berita;
use App\Models\Layanan;
use App\Models\Visitor;
use App\Models\FormSubmission;
use App\Models\Form;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Dashboard extends Component
{
    // SLiMS database connection configuration
    public $slimsEnabled = false;
    public $slimsHost = '127.0.0.1';
    public $slimsPort = '3306';
    public $slimsDatabase = 'slims';
    public $slimsUsername = 'root';
    public $slimsPassword = '';

    // Test connection states
    public $testStatus = null; // 'success', 'failed', or null
    public $testMessage = null;

    protected $rules = [
        'slimsEnabled' => 'boolean',
        'slimsHost' => 'required|string',
        'slimsPort' => 'required|numeric',
        'slimsDatabase' => 'required|string',
        'slimsUsername' => 'required|string',
        'slimsPassword' => 'nullable|string',
    ];

    public function mount()
    {
        $this->slimsEnabled = (bool) config('services.slims.enabled', false);
        $this->slimsHost = config('database.connections.slims.host', '127.0.0.1');
        $this->slimsPort = config('database.connections.slims.port', '3306');
        $this->slimsDatabase = config('database.connections.slims.database', 'slims');
        $this->slimsUsername = config('database.connections.slims.username', 'root');
        $this->slimsPassword = config('database.connections.slims.password', '');
    }

    public function testConnection()
    {
        $this->validate();
        $this->testStatus = 'testing';
        $this->testMessage = null;

        try {
            // Temporarily define connection configuration in Laravel runtime
            config([
                'database.connections.slims_test' => [
                    'driver' => 'mysql',
                    'host' => $this->slimsHost,
                    'port' => $this->slimsPort,
                    'database' => $this->slimsDatabase,
                    'username' => $this->slimsUsername,
                    'password' => $this->slimsPassword,
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
        } catch (\Exception $e) {
            $this->testStatus = 'failed';
            $this->testMessage = 'Koneksi gagal: ' . $e->getMessage();
        }
    }

    public function saveSettings()
    {
        $this->validate();

        $data = [
            'SLIMS_CONNECTION_ENABLED' => $this->slimsEnabled ? 'true' : 'false',
            'DB_SLIMS_HOST' => $this->slimsHost,
            'DB_SLIMS_PORT' => $this->slimsPort,
            'DB_SLIMS_DATABASE' => $this->slimsDatabase,
            'DB_SLIMS_USERNAME' => $this->slimsUsername,
            'DB_SLIMS_PASSWORD' => $this->slimsPassword,
        ];

        if ($this->updateEnvFile($data)) {
            session()->flash('settings_success', 'Konfigurasi SLiMS berhasil disimpan.');
        } else {
            session()->flash('settings_error', 'Gagal menyimpan konfigurasi ke file .env.');
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
            \Illuminate\Support\Facades\Artisan::call('config:clear');

            return true;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Failed to update .env file: " . $e->getMessage());
            return false;
        }
    }

    public function render()
    {
        // ===== ISBN Stats =====
        $stats = [
            'users'        => User::count(),
            'isbn_pending' => IsbnSubmission::whereNotIn('workflow_status', ['selesai'])->count(),
            'isbn_selesai' => IsbnSubmission::where('workflow_status', 'selesai')->count(),
            'berita'       => Berita::count(),
            'layanan'      => Layanan::count(),
        ];

        // ===== Visitor Stats (30 days) =====
        $last30Days = collect(range(29, 0))->map(function ($i) {
            return Carbon::today()->subDays($i)->format('Y-m-d');
        });

        $visitorData = Visitor::select(
                DB::raw('DATE(visit_date) as date'),
                DB::raw('COUNT(*) as total')
            )
            ->where('visit_date', '>=', Carbon::today()->subDays(29))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date');

        $visitorChartLabels = $last30Days->map(fn($d) => Carbon::parse($d)->format('d M'))->values()->toArray();
        $visitorChartData   = $last30Days->map(fn($d) => $visitorData->get($d, 0))->values()->toArray();

        // ===== Layanan (Service) Stats =====
        $serviceStats = FormSubmission::select('form_id', DB::raw('COUNT(*) as total'))
            ->groupBy('form_id')
            ->with('form:id,title')
            ->get()
            ->map(fn($s) => ['label' => $s->form->title ?? 'Layanan #' . $s->form_id, 'total' => $s->total]);

        // ===== Summary numbers =====
        $visitorToday = Visitor::whereDate('visit_date', today())->count();
        $visitorWeek  = Visitor::where('visit_date', '>=', Carbon::today()->subDays(6))->count();
        $visitorMonth = Visitor::where('visit_date', '>=', Carbon::today()->subDays(29))->count();

        return view('livewire.admin.dashboard', [
            'stats'               => $stats,
            'recentSubmissions'   => IsbnSubmission::with('user')->latest()->take(5)->get(),
            'visitorChartLabels'  => json_encode($visitorChartLabels),
            'visitorChartData'    => json_encode($visitorChartData),
            'serviceStats'        => $serviceStats,
            'visitorToday'        => $visitorToday,
            'visitorWeek'         => $visitorWeek,
            'visitorMonth'        => $visitorMonth,
        ])->layout('layouts.admin');
    }
}
