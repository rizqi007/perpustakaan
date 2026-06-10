<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LibraryProfileResource\Pages;
use App\Models\LibraryProfile;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LibraryProfileResource extends Resource
{
    protected static ?string $model = LibraryProfile::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';
    
    protected static ?string $navigationLabel = 'Profil & Sejarah Perpustakaan';
    
    protected static ?string $modelLabel = 'Profil & Sejarah Perpustakaan';

    protected static ?string $navigationGroup = 'Tentang';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Profil Perpustakaan')
                    ->tabs([
                        // Tab 1: Visi, Misi, Tagline
                        Forms\Components\Tabs\Tab::make('Visi & Misi')
                            ->icon('heroicon-o-light-bulb')
                            ->schema([
                                Forms\Components\Textarea::make('visi')
                                    ->label('Visi Perpustakaan')
                                    ->required()
                                    ->rows(4)
                                    ->columnSpanFull()
                                    ->placeholder('Masukkan visi perpustakaan'),
                                
                                Forms\Components\Repeater::make('misi')
                                    ->label('Misi Perpustakaan')
                                    ->schema([
                                        Forms\Components\Textarea::make('item')
                                            ->label('')
                                            ->required()
                                            ->rows(2)
                                            ->placeholder('Masukkan poin misi'),
                                    ])
                                    ->required()
                                    ->minItems(1)
                                    ->columnSpanFull()
                                    ->addActionLabel('Tambah Misi')
                                    ->reorderable()
                                    ->collapsible(),
                                
                                Forms\Components\TextInput::make('tagline')
                                    ->label('Tagline Perpustakaan')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Contoh: Gerbang Ilmu Pengetahuan')
                                    ->columnSpanFull(),
                            ]),
                        
                        // Tab 2: Fungsi Perpustakaan
                        Forms\Components\Tabs\Tab::make('Fungsi Perpustakaan')
                            ->icon('heroicon-o-clipboard-document-list')
                            ->schema([
                                Forms\Components\Repeater::make('functions')
                                    ->label('Fungsi Perpustakaan Khusus')
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->label('Judul Fungsi')
                                            ->required()
                                            ->columnSpanFull(),
                                        
                                        Forms\Components\RichEditor::make('description')
                                            ->label('Deskripsi')
                                            ->required()
                                            ->columnSpanFull()
                                            ->toolbarButtons([
                                                'bold',
                                                'italic',
                                                'underline',
                                                'bulletList',
                                                'orderedList',
                                            ]),
                                    ])
                                    ->columnSpanFull()
                                    ->addActionLabel('Tambah Fungsi')
                                    ->reorderable()
                                    ->collapsible()
                                    ->itemLabel(fn (array $state): ?string => $state['title'] ?? null),
                            ]),
                        
                        // Tab 3: Tugas Perpustakaan Kemenag
                        Forms\Components\Tabs\Tab::make('Tugas Perpustakaan')
                            ->icon('heroicon-o-clipboard-document-check')
                            ->schema([
                                Forms\Components\Repeater::make('tasks')
                                    ->label('Tugas Perpustakaan Kemenag')
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->label('Judul Tugas')
                                            ->required()
                                            ->columnSpanFull(),
                                        
                                        Forms\Components\RichEditor::make('description')
                                            ->label('Deskripsi')
                                            ->required()
                                            ->columnSpanFull()
                                            ->toolbarButtons([
                                                'bold',
                                                'italic',
                                                'underline',
                                                'bulletList',
                                                'orderedList',
                                            ]),
                                    ])
                                    ->columnSpanFull()
                                    ->addActionLabel('Tambah Tugas')
                                    ->reorderable()
                                    ->collapsible()
                                    ->itemLabel(fn (array $state): ?string => $state['title'] ?? null),
                            ]),
                        
                        // Tab 4: Dasar Hukum
                        Forms\Components\Tabs\Tab::make('Dasar Hukum')
                            ->icon('heroicon-o-scale')
                            ->schema([
                                Forms\Components\Repeater::make('legal_bases')
                                    ->label('Dasar Hukum')
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->label('Judul Dokumen')
                                            ->required()
                                            ->placeholder('Contoh: Undang-Undang Perpustakaan')
                                            ->columnSpan(2),
                                        
                                        Forms\Components\TextInput::make('document_number')
                                            ->label('Nomor Dokumen')
                                            ->placeholder('Contoh: UU No. 43 Tahun 2007')
                                            ->columnSpan(1),
                                        
                                        Forms\Components\DatePicker::make('date')
                                            ->label('Tanggal')
                                            ->displayFormat('d/m/Y')
                                            ->columnSpan(1),
                                        
                                        Forms\Components\Textarea::make('description')
                                            ->label('Deskripsi')
                                            ->required()
                                            ->rows(3)
                                            ->columnSpanFull(),
                                        
                                        Forms\Components\FileUpload::make('file_path')
                                            ->label('Upload Dokumen')
                                            ->directory('legal-documents')
                                            ->acceptedFileTypes(['application/pdf'])
                                            ->maxSize(5120)
                                            ->helperText('Format: PDF, Maksimal 5MB')
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(4)
                                    ->columnSpanFull()
                                    ->addActionLabel('Tambah Dasar Hukum')
                                    ->reorderable()
                                    ->collapsible()
                                    ->itemLabel(fn (array $state): ?string => $state['title'] ?? null),
                            ]),
                        
                        // Tab 5: Milestone
                        Forms\Components\Tabs\Tab::make('Milestone')
                            ->icon('heroicon-o-flag')
                            ->schema([
                                Forms\Components\Repeater::make('milestones')
                                    ->label('Milestone Perpustakaan')
                                    ->schema([
                                        Forms\Components\TextInput::make('year')
                                            ->label('Tahun')
                                            ->required()
                                            ->numeric()
                                            ->minValue(1900)
                                            ->maxValue(2100)
                                            ->placeholder('2024')
                                            ->columnSpan(1),
                                        
                                        Forms\Components\TextInput::make('title')
                                            ->label('Judul')
                                            ->required()
                                            ->placeholder('Contoh: Digitalisasi Koleksi')
                                            ->columnSpan(3),
                                        
                                        Forms\Components\Textarea::make('description')
                                            ->label('Deskripsi')
                                            ->required()
                                            ->rows(3)
                                            ->columnSpanFull(),
                                        
                                        Forms\Components\FileUpload::make('image_path')
                                            ->label('Upload Gambar')
                                            ->directory('milestones')
                                            ->image()
                                            ->imageEditor()
                                            ->maxSize(2048)
                                            ->helperText('Format: JPG, PNG. Maksimal 2MB')
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(4)
                                    ->columnSpanFull()
                                    ->addActionLabel('Tambah Milestone')
                                    ->reorderable()
                                    ->collapsible()
                                    ->itemLabel(fn (array $state): ?string => ($state['year'] ?? '') . ' - ' . ($state['title'] ?? '')),
                            ]),
                        
                        // Tab 6: Koleksi
                        Forms\Components\Tabs\Tab::make('Koleksi')
                            ->icon('heroicon-o-book-open')
                            ->schema([
                                Forms\Components\Repeater::make('collections')
                                    ->label('Koleksi Perpustakaan')
                                    ->schema([
                                        Forms\Components\Select::make('category')
                                            ->label('Kategori')
                                            ->required()
                                            ->options([
                                                'Buku' => 'Buku',
                                                'Jurnal' => 'Jurnal',
                                                'Majalah' => 'Majalah',
                                                'Koran' => 'Koran',
                                                'E-Book' => 'E-Book',
                                                'Multimedia' => 'Multimedia',
                                                'Manuscript' => 'Manuscript',
                                                'Arsip' => 'Arsip',
                                                'Audio Visual' => 'Audio Visual',
                                                'Karya Ilmiah' => 'Karya Ilmiah',
                                            ])
                                            ->searchable()
                                            ->native(false)
                                            ->columnSpan(2),
                                        
                                        Forms\Components\TextInput::make('quantity')
                                            ->label('Jumlah')
                                            ->required()
                                            ->numeric()
                                            ->minValue(0)
                                            ->default(0)
                                            ->suffix('item')
                                            ->columnSpan(2),
                                        
                                        Forms\Components\TextInput::make('title')
                                            ->label('Judul Koleksi')
                                            ->required()
                                            ->placeholder('Contoh: Koleksi Buku Agama Islam')
                                            ->columnSpanFull(),
                                        
                                        Forms\Components\Textarea::make('description')
                                            ->label('Deskripsi')
                                            ->rows(3)
                                            ->columnSpanFull(),
                                        
                                        Forms\Components\FileUpload::make('cover_image')
                                            ->label('Upload Cover')
                                            ->directory('collection-covers')
                                            ->image()
                                            ->imageEditor()
                                            ->maxSize(2048)
                                            ->helperText('Format: JPG, PNG. Maksimal 2MB')
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(4)
                                    ->columnSpanFull()
                                    ->addActionLabel('Tambah Koleksi')
                                    ->reorderable()
                                    ->collapsible()
                                    ->itemLabel(fn (array $state): ?string => ($state['category'] ?? '') . ' - ' . ($state['title'] ?? '')),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->persistTabInQueryString(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('visi')
                    ->label('Visi')
                    ->limit(50)
                    ->searchable()
                    ->wrap(),
                
                Tables\Columns\TextColumn::make('tagline')
                    ->label('Tagline')
                    ->searchable()
                    ->badge()
                    ->color('success'),
                
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Terakhir Diperbarui')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLibraryProfiles::route('/'),
            'create' => Pages\CreateLibraryProfile::route('/create'),
            'edit' => Pages\EditLibraryProfile::route('/{record}/edit'),
        ];
    }
}