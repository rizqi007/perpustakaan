<?php

namespace App\Filament\Pages;

use App\Models\WebsiteSetting;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\HtmlString;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class ManageWebsiteSettings extends Page implements HasForms
{
    use InteractsWithForms;
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationLabel = 'Pengaturan Website';
    protected static ?string $title = 'Pengaturan Website';
    protected static ?string $slug = 'website-settings';
    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?int $navigationSort = 99;

    protected static string $view = 'filament.pages.manage-website-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $settings = WebsiteSetting::get();
        $this->form->fill($settings->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // Section 1: Umum & Tampilan
                Forms\Components\Section::make('Umum & Tampilan')
                    ->description('Pengaturan tampilan dan identitas website')
                    ->icon('heroicon-o-paint-brush')
                    ->schema([
                        // Banner Notification subsection
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\Toggle::make('notification_banner_enabled')
                                    ->label('Aktifkan Banner Notifikasi')
                                    ->helperText('Akan muncul di bagian atas halaman utama (Welcome Page).')
                                    ->live(),
                                Forms\Components\TextInput::make('notification_banner_text')
                                    ->label('Teks Notifikasi')
                                    ->placeholder('Contoh: Sedang Dalam Pengembangan')
                                    ->visible(fn (Get $get) => $get('notification_banner_enabled'))
                                    ->maxLength(255),
                            ])
                            ->compact(),

                        // Preview Header
                        Forms\Components\Placeholder::make('preview_header')
                            ->label('Preview Header:')
                            ->content(function (Get $get) {
                                $siteName = $get('site_name') ?: 'Website Name';
                                return new HtmlString("
                                    <div style='display: flex; align-items: center; gap: 12px; padding: 12px 16px; background: rgba(255,255,255,0.05); border-radius: 8px;'>
                                        <img src='" . asset('images/logo.png') . "' style='width: 40px; height: 40px; object-fit: contain;' onerror=\"this.style.display='none'\" />
                                        <span style='font-size: 1.25rem; font-weight: 700;'>{$siteName}</span>
                                    </div>
                                ");
                            })
                            ->live(),

                        Forms\Components\TextInput::make('site_name')
                            ->label('Nama Website')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true),

                        Forms\Components\Select::make('website_font')
                            ->label('Font Website')
                            ->options([
                                'poppins' => 'Poppins (Geometris, Bersih)',
                                'outfit' => 'Outfit (Modern, Elegan)',
                                'plus_jakarta_sans' => 'Plus Jakarta Sans (Sangat Terbaca)',
                                'inter' => 'Inter (Standar UI)',
                                'verdana' => 'Verdana (Klasik, Sangat Terbaca)',
                            ])
                            ->required()
                            ->native(false),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\FileUpload::make('logo')
                                    ->label('Logo Website (Gambar)')
                                    ->image()
                                    ->directory('settings')
                                    ->visibility('public')
                                    ->imagePreviewHeight('80'),
                                Forms\Components\FileUpload::make('favicon')
                                    ->label('Favicon')
                                    ->image()
                                    ->directory('settings')
                                    ->visibility('public')
                                    ->imagePreviewHeight('40'),
                            ]),
                    ]),

                // Section 2: Mode Pemeliharaan
                Forms\Components\Section::make('Mode Pemeliharaan')
                    ->description('Atur mode maintenance untuk menutup akses sementara')
                    ->icon('heroicon-o-wrench-screwdriver')
                    ->schema([
                        Forms\Components\Toggle::make('maintenance_mode')
                            ->label('Aktifkan Maintenance Mode')
                            ->helperText('Jika aktif, hanya admin yang dapat mengakses website.')
                            ->live(),
                        Forms\Components\Textarea::make('maintenance_message')
                            ->label('Pesan Maintenance')
                            ->placeholder('Contoh: Website sedang dalam perbaikan. Silakan kunjungi kembali nanti.')
                            ->visible(fn (Get $get) => $get('maintenance_mode'))
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                // Section 3: Integrasi Sosial Media
                Forms\Components\Section::make('Integrasi Sosial Media')
                    ->description('Pengaturan integrasi dengan platform eksternal')
                    ->icon('heroicon-o-share')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('facebook_url')
                                    ->label('Facebook URL')
                                    ->placeholder('https://facebook.com/...'),
                                Forms\Components\TextInput::make('twitter_url')
                                    ->label('Twitter / X URL')
                                    ->placeholder('https://twitter.com/...'),
                                Forms\Components\TextInput::make('instagram_url')
                                    ->label('Instagram URL')
                                    ->placeholder('https://instagram.com/...'),
                                Forms\Components\TextInput::make('youtube_url')
                                    ->label('YouTube URL')
                                    ->placeholder('https://youtube.com/channel/...'),
                            ]),

                        Forms\Components\Textarea::make('instagram_embed_code')
                            ->label('Kode Embed Instagram / Widget')
                            ->helperText('Tempelkan kode embed dari layanan pihak ketiga (misal: SnapWidget, Elfsight) untuk menampilkan feed Instagram otomatis. Jika diisi, ini akan menggantikan galeri manual di halaman depan.')
                            ->rows(5)
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        $settings = WebsiteSetting::get();
        $settings->update($data);

        // Clear cache
        \Illuminate\Support\Facades\Cache::forget('website_settings_global');

        Notification::make()
            ->success()
            ->title('Pengaturan disimpan')
            ->body('Pengaturan website berhasil diperbarui.')
            ->send();
    }
}
