<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DaftarHadirResource\Pages;
use App\Models\Form as FormModel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class DaftarHadirResource extends Resource
{
    protected static ?string $model = FormModel::class;
    
    protected static ?string $slug = 'daftar-hadir';

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationLabel = 'Daftar Hadir';

    protected static ?string $modelLabel = 'Daftar Hadir';

    protected static ?string $pluralModelLabel = 'Daftar Hadir';

    protected static ?string $navigationGroup = 'Formulir';

    protected static ?int $navigationSort = 3;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where(function ($query) {
            $query->where('slug', 'like', 'daftar-hadir-%')
                  ->orWhere('slug', 'daftar-hadir-pengunjung');
        });
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Tabs')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Data Formulir')
                            ->schema([
                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->label('Judul Daftar Hadir / Nama Acara')
                                            ->required()
                                            ->maxLength(255)
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(function (\Filament\Forms\Set $set, ?string $state) {
                                                // Slug internal selalu diawali 'daftar-hadir-' untuk filter query
                                                $slug = \Illuminate\Support\Str::slug($state);
                                                if (!str_starts_with($slug, 'daftar-hadir-')) {
                                                    $slug = 'daftar-hadir-' . $slug;
                                                }
                                                $set('slug', $slug);
                                            }),
                                        Forms\Components\TextInput::make('slug')
                                            ->label('Slug Internal (Otomatis)')
                                            ->required()
                                            ->maxLength(255)
                                            ->readOnly()
                                            ->helperText('Diisi otomatis. URL publik: /daftar-hadir/{judul-acara}'),
                                    ]),
                                Forms\Components\Grid::make(3)
                                    ->schema([
                                        Forms\Components\DatePicker::make('start_date')
                                            ->label('Tanggal Mulai')
                                            ->native(false)
                                            ->displayFormat('d/m/Y')
                                            ->closeOnDateSelection(),
                                        Forms\Components\DatePicker::make('end_date')
                                            ->label('Tanggal Selesai')
                                            ->native(false)
                                            ->displayFormat('d/m/Y')
                                            ->closeOnDateSelection()
                                            ->afterOrEqual('start_date'),
                                        Forms\Components\TextInput::make('max_quota')
                                            ->label('Kuota Maksimal')
                                            ->numeric()
                                            ->placeholder('Kosongkan jika tidak terbatas'),
                                    ]),
                                Forms\Components\FileUpload::make('cover_image')
                                    ->label('Gambar Sampul / Banner Header')
                                    ->image()
                                    ->directory('form-covers')
                                    ->visibility('public')
                                    ->columnSpanFull()
                                    ->helperText('Upload gambar sampul untuk header formulir. Ukuran ideal: 1200x400 piksel.'),
                                Forms\Components\Textarea::make('description')
                                    ->label('Keterangan / Petunjuk Pengisian')
                                    ->columnSpanFull()
                                    ->rows(3),
                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\ColorPicker::make('theme_color')
                                            ->label('Warna Tema Utama')
                                            ->default('#059669')
                                            ->helperText('Akan digunakan sebagai warna utama tombol, aksen, dan border header.'),
                                        Forms\Components\ColorPicker::make('bg_color')
                                            ->label('Warna Latar Belakang Halaman')
                                            ->default('#f0fdf4')
                                            ->helperText('Latar belakang halaman formulir (disarankan warna yang lembut).'),
                                    ]),
                                
                                Forms\Components\Repeater::make('fields')
                                    ->label('Kolom Formulir')
                                    ->columnSpanFull()
                                    ->schema([
                                        Forms\Components\Grid::make(3)
                                            ->schema([
                                                Forms\Components\TextInput::make('label')
                                                    ->label('Nama Kolom (Label)')
                                                    ->required()
                                                    ->placeholder('Contoh: Nama Lengkap, Instansi'),
                                                Forms\Components\Select::make('type')
                                                    ->label('Tipe Kolom')
                                                    ->options([
                                                        'text' => 'Teks Singkat',
                                                        'email' => 'Email',
                                                        'number' => 'Angka / Nomor',
                                                        'textarea' => 'Teks Panjang',
                                                        'select' => 'Pilihan (Dropdown)',
                                                        'select_with_input' => 'Pilihan (Bisa Isi Sendiri)',
                                                        'date' => 'Tanggal',
                                                    ])
                                                    ->required()
                                                    ->live(),
                                                Forms\Components\Toggle::make('required')
                                                    ->label('Wajib Diisi')
                                                    ->inline(false)
                                                    ->default(true),
                                            ]),
                                        Forms\Components\Grid::make(1)
                                            ->schema([
                                                Forms\Components\TextInput::make('helper_text')
                                                    ->label('Petunjuk Kolom (Opsional)')
                                                    ->placeholder('Contoh: Isi dengan format +628... atau 08...'),
                                                Forms\Components\KeyValue::make('options')
                                                    ->label('Daftar Pilihan (Wajib untuk tipe Pilihan)')
                                                    ->visible(fn (\Filament\Forms\Get $get) => in_array($get('type'), ['select', 'select_with_input'])),
                                            ]),
                                    ])
                                    ->default([
                                        [
                                            'type' => 'text',
                                            'label' => 'Nama',
                                            'required' => true,
                                            'helper_text' => 'Nama lengkap Anda',
                                        ],
                                        [
                                            'type' => 'text',
                                            'label' => 'Instansi',
                                            'required' => true,
                                            'helper_text' => 'Instansi atau asal Anda',
                                        ],
                                        [
                                            'type' => 'text',
                                            'label' => 'Nomor Handphone',
                                            'required' => true,
                                            'helper_text' => 'Nomor WhatsApp / HP aktif',
                                        ],
                                    ])
                                    ->itemLabel(fn (array $state): ?string => $state['label'] ?? null)
                                    ->collapsed(false)
                                    ->collapsible()
                                    ->cloneable()
                                    ->reorderableWithButtons(),
                                
                                Forms\Components\Toggle::make('is_active')
                                    ->label('Status Aktif')
                                    ->default(true),
                            ]),
                    ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Acara / Daftar Hadir')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug / Tautan')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Aktif'),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('Mulai')
                    ->date('d M Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->label('Selesai')
                    ->date('d M Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('max_quota')
                    ->label('Kuota')
                    ->numeric()
                    ->sortable()
                    ->state(fn ($record) => $record->max_quota ?? 'Tanpa Batas'),
                Tables\Columns\TextColumn::make('submissions_count')
                    ->label('Pendaftar / Hadir')
                    ->counts('submissions')
                    ->sortable()
                    ->badge()
                    ->color('success'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('share_link')
                        ->label('Link & Barcode')
                        ->icon('heroicon-o-qr-code')
                        ->color('success')
                        ->modalHeading(fn ($record) => 'Link & Barcode: ' . $record->title)
                        ->modalWidth('md')
                        ->modalSubmitAction(false)
                        ->modalCancelActionLabel('Tutup')
                        ->form([
                            Forms\Components\Placeholder::make('share_info')
                                ->label('')
                                ->content(function ($record) {
                                    // URL publik: /daftar-hadir/{judul-acara} (tanpa duplikasi prefix)
                                    $publicSlug = preg_replace('/^daftar-hadir-/', '', $record->slug);
                                    $url = route('daftar-hadir.show', ['slug' => $publicSlug]);
                                    
                                    // Generate local QR Code as base64 SVG (bebas internet, bebas CORS)
                                    ob_start();
                                    $oldErrorReporting = error_reporting(0);
                                    @ini_set('display_errors', '0');
                                    try {
                                        $qrCodeSvg = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')
                                            ->size(200)
                                            ->margin(1)
                                            ->errorCorrection('H')
                                            ->generate($url);
                                    } finally {
                                        error_reporting($oldErrorReporting);
                                        ob_end_clean();
                                    }

                                    if (isset($qrCodeSvg)) {
                                        if (($pos = strpos($qrCodeSvg, '<?xml')) !== false) {
                                            $qrCodeSvg = substr($qrCodeSvg, $pos);
                                        } elseif (($pos = strpos($qrCodeSvg, '<svg')) !== false) {
                                            $qrCodeSvg = substr($qrCodeSvg, $pos);
                                        }
                                    }

                                    $qrSrc = 'data:image/svg+xml;base64,' . base64_encode($qrCodeSvg);
                                    
                                    $uniqueId = 'copy_toast_' . $record->id;

                                    return new \Illuminate\Support\HtmlString("
                                        <div class='flex flex-col items-center justify-center text-center space-y-5 py-2' id='share_wrapper_{$record->id}'>

                                            <!-- Toast Notification -->
                                            <div id='{$uniqueId}'
                                                style='display:none; position:fixed; top:24px; left:50%; transform:translateX(-50%); z-index:99999;'
                                            >
                                                <div style='
                                                    background: linear-gradient(135deg, #065f46, #059669);
                                                    color: white;
                                                    padding: 12px 24px;
                                                    border-radius: 50px;
                                                    font-weight: 700;
                                                    font-size: 14px;
                                                    box-shadow: 0 8px 32px rgba(6,95,70,0.4);
                                                    display: flex;
                                                    align-items: center;
                                                    gap: 10px;
                                                    white-space: nowrap;
                                                '>
                                                    <svg width='18' height='18' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                                                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='M5 13l4 4L19 7'/>
                                                    </svg>
                                                    Tautan berhasil disalin!
                                                </div>
                                            </div>

                                            <!-- QR Code with Centered Kemenag Logo -->
                                            <div style='position:relative; padding:16px; background:white; border-radius:20px; box-shadow:0 4px 20px rgba(0,0,0,0.08); border:1px solid #e5e7eb; display:flex; justify-content:center; align-items:center;'>
                                                <img src='{$qrSrc}' alt='QR Code' style='width:200px; height:200px; display:block;' />
                                                <div style='position:absolute; width:44px; height:44px; background:white; border-radius:8px; display:flex; justify-content:center; align-items:center; box-shadow:0 2px 8px rgba(0,0,0,0.15);'>
                                                    <img src='/images/logo.png' alt='Kemenag' style='width:34px; height:34px; object-fit:contain;' />
                                                </div>
                                            </div>

                                            <!-- Link Section -->
                                            <div style='width:100%;'>
                                                <p style='font-size:11px; font-weight:700; color:#6b7280; text-transform:uppercase; letter-spacing:0.08em; text-align:left; margin-bottom:8px;'>
                                                    Tautan Form Kehadiran
                                                </p>
                                                <div style='display:flex; align-items:center; background:#f9fafb; border:1.5px solid #d1fae5; border-radius:12px; overflow:hidden;'>
                                                    <input
                                                        type='text'
                                                        id='share_url_{$record->id}'
                                                        readonly
                                                        value='{$url}'
                                                        style='flex:1; background:transparent; border:none; outline:none; padding:12px 14px; font-size:13px; font-weight:500; color:#374151; min-width:0;'
                                                    />
                                                    <button
                                                        type='button'
                                                        onclick='
                                                            navigator.clipboard.writeText(\"{$url}\").then(function() {
                                                                var toast = document.getElementById(\"{$uniqueId}\");
                                                                toast.style.display = \"block\";
                                                                toast.style.opacity = \"1\";
                                                                setTimeout(function() {
                                                                    toast.style.transition = \"opacity 0.4s\";
                                                                    toast.style.opacity = \"0\";
                                                                    setTimeout(function() { toast.style.display = \"none\"; toast.style.opacity = \"1\"; }, 400);
                                                                }, 2000);
                                                            });
                                                        '
                                                        style='
                                                            flex-shrink:0;
                                                            background: linear-gradient(135deg, #059669, #065f46);
                                                            color: white;
                                                            border: none;
                                                            padding: 10px 18px;
                                                            font-size: 13px;
                                                            font-weight: 700;
                                                            cursor: pointer;
                                                            display: flex;
                                                            align-items: center;
                                                            gap: 6px;
                                                            transition: opacity 0.2s;
                                                            margin: 4px;
                                                            border-radius: 8px;
                                                        '
                                                        onmouseover='this.style.opacity=0.85'
                                                        onmouseout='this.style.opacity=1'
                                                    >
                                                        <svg width='15' height='15' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                                                            <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2.5' d='M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3'/>
                                                        </svg>
                                                        Salin
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Download QR as PNG using browser Canvas (no CORS, offline, no imagick needed) -->
                                            <button
                                                type='button'
                                                onclick='
                                                    (function() {
                                                        var qrImg = new Image();
                                                        qrImg.src = \"{$qrSrc}\";
                                                        qrImg.onload = function() {
                                                            var logoImg = new Image();
                                                            logoImg.src = \"/images/logo.png\";
                                                            logoImg.onload = function() {
                                                                var canvas = document.createElement(\"canvas\");
                                                                canvas.width = 600;
                                                                canvas.height = 600;
                                                                var ctx = canvas.getContext(\"2d\");
                                                                
                                                                // Fill white background (QR Code must have solid background to scan)
                                                                ctx.fillStyle = \"#FFFFFF\";
                                                                ctx.fillRect(0, 0, 600, 600);
                                                                
                                                                // Draw the SVG QR Code
                                                                ctx.drawImage(qrImg, 0, 0, 600, 600);
                                                                
                                                                // Draw white box in the center for logo
                                                                var logoSize = 110;
                                                                var logoX = (600 - logoSize) / 2;
                                                                var logoY = (600 - logoSize) / 2;
                                                                
                                                                // Draw white background card for the logo
                                                                ctx.fillStyle = \"#FFFFFF\";
                                                                ctx.beginPath();
                                                                var radius = 20;
                                                                if (ctx.roundRect) {
                                                                    ctx.roundRect(logoX - 15, logoY - 15, logoSize + 30, logoSize + 30, radius);
                                                                } else {
                                                                    ctx.rect(logoX - 15, logoY - 15, logoSize + 30, logoSize + 30);
                                                                }
                                                                ctx.fill();
                                                                
                                                                // Draw the Logo
                                                                ctx.drawImage(logoImg, logoX, logoY, logoSize, logoSize);
                                                                
                                                                // Trigger PNG download
                                                                var pngUrl = canvas.toDataURL(\"image/png\");
                                                                var a = document.createElement(\"a\");
                                                                a.href = pngUrl;
                                                                a.download = \"QR-{$record->slug}.png\";
                                                                document.body.appendChild(a);
                                                                a.click();
                                                                document.body.removeChild(a);
                                                            };
                                                            logoImg.onerror = function() {
                                                                // Fallback if logo fails: download without logo
                                                                var canvas = document.createElement(\"canvas\");
                                                                canvas.width = 600;
                                                                canvas.height = 600;
                                                                var ctx = canvas.getContext(\"2d\");
                                                                ctx.fillStyle = \"#FFFFFF\";
                                                                ctx.fillRect(0, 0, 600, 600);
                                                                ctx.drawImage(qrImg, 0, 0, 600, 600);
                                                                
                                                                var pngUrl = canvas.toDataURL(\"image/png\");
                                                                var a = document.createElement(\"a\");
                                                                a.href = pngUrl;
                                                                a.download = \"QR-{$record->slug}.png\";
                                                                document.body.appendChild(a);
                                                                a.click();
                                                                document.body.removeChild(a);
                                                            };
                                                        };
                                                    })();
                                                '
                                                style='
                                                    display:flex; align-items:center; justify-content:center; gap:8px;
                                                    width:100%; padding:12px 16px;
                                                    background:white; border:1.5px solid #e5e7eb; border-radius:12px;
                                                    font-size:13px; font-weight:700; color:#374151;
                                                    cursor:pointer; transition:background 0.2s;
                                                '
                                                onmouseover='this.style.background=\"#f9fafb\"'
                                                onmouseout='this.style.background=\"white\"'
                                            >
                                                <svg width='18' height='18' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                                                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4'/>
                                                </svg>
                                                Unduh Barcode (QR Code PNG)
                                            </button>
                                        </div>
                                    ");
                                })
                        ]),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
                ->icon('heroicon-m-ellipsis-vertical')
                ->tooltip('Aksi'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            \App\Filament\Resources\FormResource\RelationManagers\SubmissionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDaftarHadir::route('/'),
            'create' => Pages\CreateDaftarHadir::route('/create'),
            'edit' => Pages\EditDaftarHadir::route('/{record}/edit'),
        ];
    }
}
