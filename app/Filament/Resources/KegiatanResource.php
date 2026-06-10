<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KegiatanResource\Pages;
use App\Models\Kegiatan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use AmidEsfahani\FilamentTinyEditor\TinyEditor;

class KegiatanResource extends Resource
{
    protected static ?string $model = Kegiatan::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationLabel = 'Kegiatan';

    protected static ?string $navigationGroup = 'Manajemen Web';

    protected static ?string $modelLabel = 'Kegiatan';

    protected static ?string $pluralModelLabel = 'Kegiatan';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Main content column (left)
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Informasi Kegiatan')
                            ->schema([
                                Forms\Components\TextInput::make('judul')
                                    ->label('Judul Kegiatan')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('slug', Str::slug($state)))
                                    ->columnSpanFull(),
                                Forms\Components\Select::make('kategori')
                                    ->label('Kategori')
                                    ->options([
                                        'seminar' => 'Seminar',
                                        'bedah_buku' => 'Bedah Buku',
                                        'workshop' => 'Workshop',
                                        'diskusi' => 'Diskusi',
                                        'pameran' => 'Pameran',
                                        'lainnya' => 'Lainnya',
                                    ])
                                    ->required()
                                    ->default('lainnya'),
                                Forms\Components\TextInput::make('slug')
                                    ->label('Slug URL')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),
                                TinyEditor::make('deskripsi')
                                    ->label('Deskripsi')
                                    ->columnSpanFull()
                                    ->fileAttachmentsDisk('public')
                                    ->fileAttachmentsDirectory('kegiatan-images')
                                    ->profile('full')
                                    ->required(),
                            ])->columns(2),

                        Forms\Components\Section::make('Narasumber')
                            ->schema([
                                Forms\Components\Repeater::make('narasumber')
                                    ->label('')
                                    ->schema([
                                        Forms\Components\TextInput::make('nama')
                                            ->label('Nama Narasumber')
                                            ->required(),
                                        Forms\Components\TextInput::make('jabatan')
                                            ->label('Jabatan / Instansi'),
                                        Forms\Components\FileUpload::make('foto')
                                            ->label('Foto')
                                            ->image()
                                            ->directory('kegiatan-narasumber')
                                            ->maxSize(2048),
                                    ])
                                    ->columns(3)
                                    ->collapsible()
                                    ->defaultItems(0)
                                    ->addActionLabel('Tambah Narasumber')
                                    ->columnSpanFull(),
                            ])->collapsible(),

                        Forms\Components\Section::make('Dokumen & Media')
                            ->schema([
                                Forms\Components\FileUpload::make('file_paparan')
                                    ->label('File Paparan (PDF/PPT)')
                                    ->acceptedFileTypes(['application/pdf', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation'])
                                    ->directory('kegiatan-paparan')
                                    ->maxSize(20480),
                                Forms\Components\FileUpload::make('file_artikel')
                                    ->label('Artikel / Makalah (PDF)')
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->directory('kegiatan-artikel')
                                    ->maxSize(20480),
                                Forms\Components\TextInput::make('link_rekaman')
                                    ->label('Link Rekaman Video')
                                    ->url()
                                    ->placeholder('https://youtube.com/watch?v=...')
                                    ->suffixIcon('heroicon-o-video-camera'),
                                Forms\Components\TextInput::make('link_dokumentasi')
                                    ->label('Link Dokumentasi Foto')
                                    ->url()
                                    ->placeholder('https://drive.google.com/...')
                                    ->suffixIcon('heroicon-o-photo'),
                                Forms\Components\FileUpload::make('galeri')
                                    ->label('Galeri Foto')
                                    ->image()
                                    ->multiple()
                                    ->reorderable()
                                    ->directory('kegiatan-galeri')
                                    ->maxSize(5120)
                                    ->columnSpanFull(),
                            ])->columns(2)->collapsible(),
                    ])
                    ->columnSpan(['lg' => 2]),

                // Sidebar column (right)
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Cover / Poster')
                            ->schema([
                                Forms\Components\FileUpload::make('cover_image')
                                    ->label('Cover Poster')
                                    ->image()
                                    ->directory('kegiatan-covers')
                                    ->maxSize(5120),
                            ]),

                        Forms\Components\Section::make('Waktu & Tempat')
                            ->schema([
                                Forms\Components\DatePicker::make('tanggal_mulai')
                                    ->label('Tanggal Mulai')
                                    ->required(),
                                Forms\Components\DatePicker::make('tanggal_selesai')
                                    ->label('Tanggal Selesai')
                                    ->afterOrEqual('tanggal_mulai'),
                                Forms\Components\TimePicker::make('waktu_mulai')
                                    ->label('Waktu Mulai'),
                                Forms\Components\TimePicker::make('waktu_selesai')
                                    ->label('Waktu Selesai'),
                                Forms\Components\TextInput::make('lokasi')
                                    ->label('Lokasi')
                                    ->maxLength(255)
                                    ->placeholder('Contoh: Aula Lt.2, Perpustakaan Kemenag RI'),
                                Forms\Components\TextInput::make('jumlah_peserta')
                                    ->label('Jumlah Peserta')
                                    ->numeric()
                                    ->minValue(0),
                            ])->columns(1),

                        Forms\Components\Section::make('Publikasi')
                            ->schema([
                                Forms\Components\Toggle::make('is_published')
                                    ->label('Publikasikan')
                                    ->helperText('Aktifkan untuk menampilkan kegiatan di halaman publik')
                                    ->default(false),
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('tanggal_mulai', 'desc')
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')
                    ->label('Cover')
                    ->width(60)
                    ->height(40)
                    ->defaultImageUrl('https://via.placeholder.com/60x40/f3f4f6/9ca3af?text=No+Img'),
                Tables\Columns\TextColumn::make('judul')
                    ->label('Judul')
                    ->searchable()
                    ->weight('bold')
                    ->limit(40),
                Tables\Columns\TextColumn::make('kategori')
                    ->label('Kategori')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'seminar' => 'info',
                        'bedah_buku' => 'success',
                        'workshop' => 'warning',
                        'diskusi' => 'primary',
                        'pameran' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'seminar' => 'Seminar',
                        'bedah_buku' => 'Bedah Buku',
                        'workshop' => 'Workshop',
                        'diskusi' => 'Diskusi',
                        'pameran' => 'Pameran',
                        default => 'Lainnya',
                    }),
                Tables\Columns\TextColumn::make('tanggal_mulai')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('lokasi')
                    ->label('Lokasi')
                    ->limit(30)
                    ->toggleable(),
                Tables\Columns\TextColumn::make('jumlah_peserta')
                    ->label('Peserta')
                    ->numeric()
                    ->sortable()
                    ->placeholder('-'),
                Tables\Columns\IconColumn::make('is_published')
                    ->label('Publik')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori')
                    ->options([
                        'seminar' => 'Seminar',
                        'bedah_buku' => 'Bedah Buku',
                        'workshop' => 'Workshop',
                        'diskusi' => 'Diskusi',
                        'pameran' => 'Pameran',
                        'lainnya' => 'Lainnya',
                    ]),
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Status Publikasi'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKegiatan::route('/'),
            'create' => Pages\CreateKegiatan::route('/create'),
            'edit' => Pages\EditKegiatan::route('/{record}/edit'),
        ];
    }
}
