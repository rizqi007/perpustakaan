<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FormResource\Pages;
use App\Filament\Resources\FormResource\RelationManagers;
use App\Models\Form as FormModel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FormResource extends Resource
{
    protected static ?string $model = FormModel::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Kelola Formulir';

    protected static ?string $navigationGroup = 'Formulir';

    protected static ?int $navigationSort = 1;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('slug', '!=', 'daftar-hadir-pengunjung')
            ->where('slug', 'not like', 'daftar-hadir-%');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Tabs')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Data Formulir')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (\Filament\Forms\Set $set, ?string $state) => $set('slug', \Illuminate\Support\Str::slug($state))),
                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('description')
                                    ->columnSpanFull(),
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
                                Forms\Components\FileUpload::make('cover_image')
                                    ->label('Gambar Sampul / Banner Header')
                                    ->image()
                                    ->directory('form-covers')
                                    ->visibility('public')
                                    ->columnSpanFull()
                                    ->helperText('Upload gambar sampul untuk header formulir. Ukuran ideal: 1200x400 piksel.'),
                                Forms\Components\Repeater::make('fields')
                                    ->schema([
                                        Forms\Components\Select::make('type')
                                            ->options([
                                                'text' => 'Text',
                                                'email' => 'Email',
                                                'number' => 'Number',
                                                'textarea' => 'Textarea',
                                                'select' => 'Select',
                                                'select_with_input' => 'Select (Bisa Isi Sendiri)',
                                                'date' => 'Date',
                                                'file' => 'File Upload',
                                            ])
                                            ->required()
                                            ->live(),
                                        Forms\Components\TextInput::make('label')
                                            ->required(),
                                        Forms\Components\Textarea::make('helper_text')
                                            ->label('Teks Bantuan (Opsional)')
                                            ->placeholder('Contoh: viii, 93')
                                            ->rows(2),
                                        Forms\Components\Toggle::make('required'),
                                        Forms\Components\KeyValue::make('options')
                                            ->visible(fn (\Filament\Forms\Get $get) => in_array($get('type'), ['select', 'select_with_input'])),
                                    ])
                                    ->columnSpanFull(),
                                Forms\Components\Toggle::make('is_active')
                                    ->default(true),
                                
                                Forms\Components\Group::make()
                                    ->schema([
                                        Forms\Components\Grid::make(2)
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
                                            ]),
                                        Forms\Components\TextInput::make('max_quota')
                                            ->label('Kuota Maksimal')
                                            ->numeric()
                                            ->minValue(1)
                                            ->placeholder('Kosongkan jika tidak terbatas')
                                            ->helperText('Jumlah maksimal peserta yang dapat mendaftar'),
                                        Forms\Components\TextInput::make('participant_label')
                                            ->label('Label Field Nama Peserta')
                                            ->placeholder('Contoh: Nama Lengkap')
                                            ->helperText('Masukkan "Label" field dari form builder yang berisi nama peserta.'),
                                        Forms\Components\TextInput::make('quota_count_label')
                                            ->label('Label Field Jumlah Peserta')
                                            ->placeholder('Contoh: Jumlah Peserta')
                                            ->helperText('Masukkan "Label" field dari form builder yang berisi angka jumlah peserta. Jika kosong, setiap pendaftar dihitung 1.'),
                                        Forms\Components\TextInput::make('booking_date_label')
                                            ->label('Label Field Tanggal Booking')
                                            ->placeholder('Contoh: Pilihan Hari/Tanggal Nobar')
                                            ->helperText('Masukkan "Label" field dari form builder yang berisi tanggal booking. Wajib untuk kuota harian.'),
                                        Forms\Components\TextInput::make('time_slot_label')
                                            ->label('Label Field Waktu Sesi')
                                            ->placeholder('Contoh: Pilihan Waktu Nobar')
                                            ->helperText('Masukkan "Label" field dari form builder yang berisi waktu sesi. Wajib untuk kuota per sesi.'),
                                    ]),
                                Forms\Components\FileUpload::make('guidebook_path')
                                    ->label('Buku Panduan')
                                    ->directory('guidebooks')
                                    ->visibility('public')
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->helperText('Upload buku panduan (PDF) untuk pengisi formulir.'),
                            ]),
                        Forms\Components\Tabs\Tab::make('Konfigurasi Tiket')
                            ->schema([
                                // Live Preview Component
                                Forms\Components\ViewField::make('preview')
                                    ->view('filament.forms.components.ticket-preview')
                                    ->columnSpanFull()
                                    ->hiddenLabel(),

                                Forms\Components\FileUpload::make('ticket_bg_image')
                                    ->label('Background Tiket')
                                    ->image()
                                    ->directory('ticket-templates')
                                    ->visibility('public')
                                    ->helperText('Upload gambar background tiket. Ukuran bebas, sistem akan menyesuaikan.')
                                    ->live(),
                                
                                Forms\Components\Grid::make(3)
                                    ->schema([
                                        Forms\Components\Section::make('Teks Nama')
                                            ->columnSpan(1)
                                            ->schema([
                                                Forms\Components\TextInput::make('ticket_name_x')->numeric()->default(60)->label('Posisi X')->live(),
                                                Forms\Components\TextInput::make('ticket_name_y')->numeric()->default(110)->label('Posisi Y')->live(),
                                                Forms\Components\TextInput::make('ticket_name_size')->numeric()->default(32)->label('Ukuran Font')->live(),
                                                Forms\Components\ColorPicker::make('ticket_name_color')->default('#000000')->label('Warna')->live(),
                                            ]),
                                        Forms\Components\Section::make('Teks Tanggal')
                                            ->columnSpan(1)
                                            ->schema([
                                                Forms\Components\TextInput::make('ticket_date_x')->numeric()->default(60)->label('Posisi X')->live(),
                                                Forms\Components\TextInput::make('ticket_date_y')->numeric()->default(160)->label('Posisi Y')->live(),
                                                Forms\Components\TextInput::make('ticket_date_size')->numeric()->default(20)->label('Ukuran Font')->live(),
                                                Forms\Components\ColorPicker::make('ticket_date_color')->default('#333333')->label('Warna')->live(),
                                            ]),
                                    ]),
                            ]),
                    ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('is_active'),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('Mulai')
                    ->date('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('end_date')
                    ->label('Selesai')
                    ->date('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('max_quota')
                    ->label('Kuota')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('submissions_count')
                    ->label('Pendaftar')
                    ->counts('submissions')
                    ->sortable()
                    ->badge()
                    ->color('success'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('share_link')
                        ->label('Link & Barcode')
                        ->icon('heroicon-o-qr-code')
                        ->color('success')
                        ->modalHeading(fn (FormModel $record) => 'Link & Barcode: ' . $record->title)
                        ->modalWidth('md')
                        ->modalSubmitAction(false)
                        ->modalCancelActionLabel('Tutup')
                        ->form([
                            Forms\Components\Placeholder::make('share_info')
                                ->label('')
                                ->content(function (FormModel $record) {
                                    $url = route('form.show', ['slug' => $record->slug]);
                                    $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($url);
                                    
                                    return new \Illuminate\Support\HtmlString("
                                        <div class='flex flex-col items-center justify-center text-center space-y-6 py-4'>
                                            <!-- QR Code Image -->
                                            <div class='p-4 bg-white rounded-2xl shadow-md border border-gray-100'>
                                                <img src='{$qrUrl}' alt='QR Code' class='w-56 h-56 mx-auto object-contain' />
                                            </div>
                                            
                                            <!-- Link Input + Copy Button -->
                                            <div class='w-full space-y-2'>
                                                <label class='block text-xs font-semibold text-gray-500 uppercase tracking-wider text-left'>Tautan Formulir / Acara</label>
                                                <div class='flex items-center gap-2 bg-gray-50 p-1 rounded-xl border border-gray-200'>
                                                    <input type='text' id='share_url_input' readonly value='{$url}' class='flex-1 bg-transparent border-0 ring-0 focus:ring-0 text-sm font-medium px-3 text-gray-700' />
                                                    <button type='button' onclick='navigator.clipboard.writeText(\"{$url}\"); alert(\"Tautan berhasil disalin!\");' class='px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-lg transition-colors flex items-center gap-1.5 shadow-sm'>
                                                        <svg class='w-4 h-4' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3'></path></svg>
                                                        Salin
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Download QR Button -->
                                            <a href='{$qrUrl}' download='QR-{$record->slug}.png' target='_blank' class='inline-flex items-center justify-center w-full px-4 py-3 bg-white hover:bg-gray-50 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 transition shadow-sm gap-2'>
                                                <svg class='w-5 h-5 text-gray-500' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4'></path></svg>
                                                Unduh Barcode (QR Code)
                                            </a>
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
            RelationManagers\SubmissionsRelationManager::class,
            RelationManagers\BlockedDatesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListForms::route('/'),
            'create' => Pages\CreateForm::route('/create'),
            'edit' => Pages\EditForm::route('/{record}/edit'),
        ];
    }
}
