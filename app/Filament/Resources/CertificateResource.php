<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CertificateResource\Pages;
use App\Models\Certificate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CertificateResource extends Resource
{
    protected static ?string $model = Certificate::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationLabel = 'Desain Sertifikat';

    protected static ?string $navigationGroup = 'Formulir';

    protected static ?string $modelLabel = 'Desain Sertifikat';

    protected static ?string $pluralModelLabel = 'Desain Sertifikat';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Dasar & Template')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Nama Pengaturan Sertifikat')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Sertifikat Webinar Moderasi Beragama'),
                        Forms\Components\Select::make('form_id')
                            ->label('Daftar Hadir / Acara Terkait')
                            ->options(function () {
                                return \App\Models\Form::where('slug', 'like', 'daftar-hadir-%')
                                    ->orWhere('slug', 'daftar-hadir-pengunjung')
                                    ->pluck('title', 'id')
                                    ->toArray();
                            })
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->live(),
                        Forms\Components\Select::make('name_field')
                            ->label('Nama Kolom (Input) untuk Nama Peserta')
                            ->options(function (Forms\Get $get) {
                                $formId = $get('form_id');
                                if (!$formId) {
                                    return ['Nama' => 'Nama'];
                                }
                                $form = \App\Models\Form::find($formId);
                                if (!$form || empty($form->fields)) {
                                    return ['Nama' => 'Nama'];
                                }
                                return collect($form->fields)->pluck('label', 'label')->toArray();
                            })
                            ->default('Nama')
                            ->required()
                            ->helperText('Pilih kolom isian di daftar hadir yang berisi nama lengkap peserta.'),
                        Forms\Components\FileUpload::make('background_image')
                            ->label('File Gambar Background Template (Opsional)')
                            ->image()
                            ->directory('certificate-templates')
                            ->maxSize(5120)
                            ->nullable()
                            ->helperText('Unggah gambar background sertifikat (A4 Landscape, maks 5MB). Jika kosong, sistem akan menggunakan template default Kemenag.')
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Kustomisasi Teks Nama')
                    ->description('Sesuaikan posisi, ukuran, warna, dan jenis tulisan nama peserta di sertifikat.')
                    ->schema([
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('name_y')
                                    ->label('Posisi Vertikal (%)')
                                    ->numeric()
                                    ->default(45)
                                    ->minValue(0)
                                    ->maxValue(100)
                                    ->helperText('Diukur dari atas sertifikat (0-100%)'),
                                Forms\Components\TextInput::make('name_font_size')
                                    ->label('Ukuran Font (pt)')
                                    ->numeric()
                                    ->default(36)
                                    ->minValue(8)
                                    ->maxValue(100),
                                Forms\Components\ColorPicker::make('name_color')
                                    ->label('Warna Tulisan')
                                    ->default('#1f2937'),
                            ]),
                        Forms\Components\Select::make('name_font_family')
                            ->label('Model Font')
                            ->options([
                                'Great Vibes' => 'Great Vibes (Cursive/Script)',
                                'Playfair Display' => 'Playfair Display (Serif/Classic)',
                                'Montserrat' => 'Montserrat (Sans-Serif/Modern)',
                            ])
                            ->default('Great Vibes')
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Desain Default Kemenag')
                    ->description('Hanya digunakan apabila Anda tidak mengunggah gambar background template di atas.')
                    ->schema([
                        Forms\Components\Textarea::make('description')
                            ->label('Keterangan Sertifikat')
                            ->placeholder('Atas partisipasinya sebagai Peserta dalam kegiatan...')
                            ->helperText('Tinggalkan kosong untuk menggunakan keterangan standar.')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('signature_title')
                                    ->label('Jabatan Penandatangan')
                                    ->default('Kepala Perpustakaan Kemenag RI'),
                                Forms\Components\TextInput::make('signature_name')
                                    ->label('Nama Lengkap Penandatangan')
                                    ->default('H. Muhammad Ridwan, M.Ag'),
                            ]),
                        Forms\Components\FileUpload::make('signature_image')
                            ->label('File Tanda Tangan (PNG Transparan)')
                            ->image()
                            ->directory('certificate-signatures')
                            ->maxSize(2048)
                            ->nullable()
                            ->helperText('Gambar tanda tangan digital pengesah sertifikat.'),
                    ])->collapsible()->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Nama Pengaturan')
                    ->searchable()
                    ->weight('bold')
                    ->sortable(),
                Tables\Columns\TextColumn::make('form.title')
                    ->label('Daftar Hadir Terkait')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('background_image')
                    ->label('Background')
                    ->width(80)
                    ->height(50)
                    ->defaultImageUrl(fn () => 'https://via.placeholder.com/80x50/065f46/ffffff?text=Default+Kemenag'),
                Tables\Columns\TextColumn::make('name_field')
                    ->label('Kolom Nama')
                    ->badge(),
                Tables\Columns\TextColumn::make('name_font_family')
                    ->label('Font')
                    ->badge(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCertificates::route('/'),
            'create' => Pages\CreateCertificate::route('/create'),
            'edit' => Pages\EditCertificate::route('/{record}/edit'),
        ];
    }
}
