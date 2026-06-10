<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Livewire\Home;
use App\Http\Middleware\TrackVisitor;
use App\Http\Middleware\CheckMaintenanceMode;

Route::middleware([TrackVisitor::class, CheckMaintenanceMode::class])->group(function () {

    Route::get('/', Home::class)->name('landing');

    // Auth Routes (public login/register) with rate limiting
    Route::middleware(['guest', 'throttle:5,1'])->group(function () {
        Route::get('/login', App\Livewire\Auth\Login::class)->name('login');
        Route::get('/register', App\Livewire\Auth\Register::class)->name('register');
    });

    Route::post('/logout', function () {
        Auth::guard('web')->logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/');
    })->middleware('auth')->name('logout');

    // Form requires authentication
    Route::middleware('auth')->group(function () {
        // User Dashboard (unique URL per user)
        Route::get('/dashboard', function () {
            return redirect()->route('dashboard.show', ['slug' => auth()->user()->unique_slug]);
        })->name('dashboard');
        Route::get('/dashboard/{slug}', App\Livewire\Dashboard::class)->name('dashboard.show');

        Route::get('/formulir', App\Livewire\Front\FormIndex::class)->name('form.index');
        Route::get('/formulir/{slug}', App\Livewire\Front\DynamicForm::class)->name('form.show');
        
        // ISBN Routes
        Route::get('/isbn', App\Livewire\Isbn\Index::class)->name('isbn.index');
        Route::get('/isbn/ajukan', App\Livewire\Front\DynamicForm::class)
            ->defaults('slug', 'pengajuan-isbn')
            ->name('isbn.create');
        Route::get('/isbn/{submissionId}/edit', App\Livewire\Front\DynamicForm::class)
            ->defaults('slug', 'pengajuan-isbn')
            ->name('isbn.edit');

        // Daftar Anggota (requires login)
        Route::get('/daftar-anggota', \App\Livewire\DaftarAnggota::class)->name('daftar.anggota');
    });

    // Admin Routes (using isolated admin guard)
    Route::middleware('auth:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', App\Livewire\Admin\Dashboard::class)->name('dashboard');
        Route::get('/isbn', App\Livewire\Admin\Isbn\Index::class)->name('isbn.index');
    });

    // Public Routes
    Route::prefix('berita')->name('berita.')->group(function() {
        Route::get('/', App\Livewire\Berita\Index::class)->name('index');
        Route::get('/{slug}', App\Livewire\Berita\Show::class)->name('show');
    });

    Route::prefix('tentang')->name('tentang.')->group(function() {
        Route::get('/profil', App\Livewire\Pages\Profil::class)->name('profil');
        Route::get('/profil-balai', App\Livewire\Pages\ProfilBalai::class)->name('profil-balai');
        Route::get('/profil-balai/{slug}', App\Livewire\Pages\ProfilBalaiDetail::class)->name('profil-balai.show');
    });

    Route::prefix('resensi')->name('resensi.')->group(function() {
        Route::get('/', App\Livewire\Resensi\Index::class)->name('index');
        Route::get('/{slug}', App\Livewire\Resensi\Show::class)->name('show');
    });

    Route::prefix('katalog')->name('katalog.')->group(function() {
        Route::get('/', App\Livewire\Katalog\Index::class)->name('index');
        Route::get('/{book}', App\Livewire\Katalog\Show::class)->name('show');
    });

    Route::prefix('layanan')->name('layanan.')->group(function() {
        Route::get('/keanggotaan', App\Livewire\Layanan\Index::class)->name('keanggotaan');
        Route::get('/katalog-online', App\Livewire\Layanan\Index::class)->name('katalogOnline');
    });

    Route::get('/kliping-digital', App\Livewire\KlipingDigital::class)->name('kliping.index');

    // Buku Tamu (default pengunjung)
    Route::get('/daftar-hadir', \App\Livewire\Front\PublicDynamicForm::class)
        ->defaults('slug', 'daftar-hadir-pengunjung')
        ->name('buku.tamu');

    // Daftar Hadir Acara: /daftar-hadir/{judul-acara} (tanpa duplikasi prefix)
    Route::get('/daftar-hadir/{slug}', \App\Livewire\Front\PublicDynamicForm::class)
        ->name('daftar-hadir.show');

    // Kartu Anggota (public)
    Route::get('/kartu-anggota', \App\Livewire\KartuAnggota::class)->name('kartu.anggota');

    Route::get('/testimoni', App\Livewire\TestimoniPage::class)->name('testimoni.index');

    // Kegiatan
    Route::get('/kegiatan/{slug}', App\Livewire\Kegiatan\Show::class)->name('kegiatan.show');

    Route::get('/hubungi-kami', App\Livewire\Contact::class)->name('contact');

});


// Storage link removed for security - run "php artisan storage:link" manually on server


