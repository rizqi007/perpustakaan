<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KatalogBukuResource\Pages;
use App\Filament\Resources\KatalogBukuResource\RelationManagers;
use App\Models\KatalogBuku;
use App\Models\FormSubmission;
use App\Models\IsbnSubmission;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Str;

class KatalogBukuResource extends Resource
{
    protected static ?string $model = KatalogBuku::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel = 'Hasil Terbitan ISBN';
    protected static ?string $modelLabel = 'Hasil Terbitan ISBN';
    protected static ?string $pluralModelLabel = 'Hasil Terbitan ISBN';
    protected static ?string $navigationGroup = 'Layanan ISBN';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Sumber Data')
                    ->schema([
                        // Sumber dari sistem ISBN baru (IsbnSubmission)
                        Forms\Components\Select::make('isbn_submission_id')
                            ->label('Pilih dari Pengajuan ISBN (Sistem Baru)')
                            ->options(function () {
                                return IsbnSubmission::whereIn('workflow_status', [
                                        'isbn_terbit',
                                        'penyerahan_buku',
                                        'selesai',
                                    ])
                                    ->orWhere(function ($q) {
                                        $q->whereNotNull('isbn_number')->where('isbn_number', '!=', '');
                                    })
                                    ->latest()
                                    ->get()
                                    ->mapWithKeys(function ($sub) {
                                        $isbn = $sub->isbn_number ? " [ISBN: {$sub->isbn_number}]" : '';
                                        return [$sub->id => "{$sub->title} / {$sub->author}{$isbn}"];
                                    });
                            })
                            ->searchable()
                            ->live()
                            ->afterStateUpdated(function (Set $set, $state) {
                                if (!$state) return;

                                $sub = IsbnSubmission::find($state);
                                if (!$sub) return;

                                $set('judul_penanggung_jawab', trim("{$sub->title} / {$sub->author}", " /"));
                                $set('edisi', '');
                                $set('publikasi', $sub->publisher ? "{$sub->publisher}, {$sub->publication_year}" : (string)$sub->publication_year);
                                $set('deskripsi_fisik', $sub->pages ? "{$sub->pages} hlm." : '');
                                $set('identifikasi', $sub->isbn_number ? "ISBN {$sub->isbn_number}" : '');
                                $set('sinopsis', $sub->description ?? '');
                                // Bersihkan pilihan FormSubmission jika memilih dari sistem baru
                                $set('form_submission_id', null);
                            })
                            ->columnSpanFull()
                            ->helperText('Pilih dari pengajuan ISBN yang sudah memiliki nomor ISBN (status: ISBN Terbit / Penyerahan Buku / Selesai).'),

                        // Sumber dari sistem lama (FormSubmission / form builder)
                        Forms\Components\Select::make('form_submission_id')
                            ->label('Pilih dari Pengajuan Form Lama (Opsional)')
                            ->options(function () {
                                return FormSubmission::whereHas('form', function ($query) {
                                        $query->where('slug', 'pengajuan-isbn');
                                    })
                                    ->where('status', 'approved')
                                    ->get()
                                    ->mapWithKeys(function ($sub) {
                                        $titleKey = collect($sub->data)->keys()->first(fn($k) => str_contains(strtolower($k), 'judul'));
                                        $authorKey = collect($sub->data)->keys()->first(fn($k) => str_contains(strtolower($k), 'kepengarangan') || str_contains(strtolower($k), 'penulis'));
                                        $title = $titleKey ? ($sub->data[$titleKey] ?? 'Tanpa Judul') : 'Tanpa Judul';
                                        $author = $authorKey ? ($sub->data[$authorKey] ?? '') : '';
                                        $isbn = $sub->isbn_number ? " [ISBN: {$sub->isbn_number}]" : '';
                                        return [$sub->id => "{$title} - {$author}{$isbn} (ID: {$sub->id})"];
                                    });
                            })
                            ->searchable()
                            ->live()
                            ->afterStateUpdated(function (Set $set, $state) {
                                if (!$state) return;

                                $sub = FormSubmission::find($state);
                                if (!$sub) return;

                                $data = collect($sub->data);

                                $titleKey = $data->keys()->first(fn($k) => str_contains(strtolower($k), 'judul'));
                                $authorKey = $data->keys()->first(fn($k) => str_contains(strtolower($k), 'kepengarangan') || str_contains(strtolower($k), 'penulis'));
                                $editionKey = $data->keys()->first(fn($k) => str_contains(strtolower($k), 'edisi'));
                                $yearKey = $data->keys()->first(fn($k) => str_contains(strtolower($k), 'tahun terbit'));
                                $pagesKey = $data->keys()->first(fn($k) => str_contains(strtolower($k), 'jumlah halaman'));
                                $sizeKey = $data->keys()->first(fn($k) => str_contains(strtolower($k), 'tinggi buku') || str_contains(strtolower($k), 'ukuran'));
                                $synopsisKey = $data->keys()->first(fn($k) => str_contains(strtolower($k), 'sinopsis'));

                                $title = $titleKey ? ($data[$titleKey] ?? '') : '';
                                $author = $authorKey ? ($data[$authorKey] ?? '') : '';

                                $set('judul_penanggung_jawab', trim("{$title} / {$author}", " /"));
                                $set('edisi', $editionKey ? ($data[$editionKey] ?? '') : '');
                                $set('publikasi', $yearKey ? ($data[$yearKey] ?? '') : '');

                                $pages = $pagesKey ? ($data[$pagesKey] ?? '') : '';
                                $size = $sizeKey ? ($data[$sizeKey] ?? '') : '';
                                $set('deskripsi_fisik', trim("{$pages} hlm. ; {$size} cm.", " ; ."));

                                $set('identifikasi', $sub->isbn_number ? "ISBN {$sub->isbn_number}" : '');
                                $set('sinopsis', $synopsisKey ? ($data[$synopsisKey] ?? '') : '');
                                // Bersihkan pilihan IsbnSubmission jika memilih dari sistem lama
                                $set('isbn_submission_id', null);
                            })
                            ->columnSpanFull()
                            ->helperText('Sumber data lama berbasis form builder. Gunakan opsi di atas untuk pengajuan ISBN sistem baru.'),
                    ]),

                Forms\Components\Section::make('Detail Katalog')
                    ->schema([
                        Forms\Components\TextInput::make('judul_penanggung_jawab')
                            ->label('Judul dan Penanggung Jawab')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('edisi')
                            ->label('Edisi')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('publikasi')
                            ->label('Publikasi')
                            ->maxLength(255)
                            ->helperText('Contoh: Jakarta : Kementerian Agama, 2024'),

                        Forms\Components\TextInput::make('deskripsi_fisik')
                            ->label('Deskripsi Fisik')
                            ->maxLength(255)
                            ->helperText('Contoh: viii, 349 hlm. ; 21cm.'),

                        Forms\Components\TextInput::make('identifikasi')
                            ->label('Identifikasi (ISBN)')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('subjek')
                            ->label('Subjek')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('klasifikasi')
                            ->label('Klasifikasi')
                            ->maxLength(255),

                        Forms\Components\Textarea::make('sinopsis')
                            ->label('Sinopsis')
                            ->columnSpanFull()
                            ->rows(5),

                        Forms\Components\FileUpload::make('cover')
                            ->label('Cover Buku')
                            ->image()
                            ->directory('katalog_covers')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover')
                    ->label('Cover')
                    ->circular(),
                Tables\Columns\TextColumn::make('judul_penanggung_jawab')
                    ->label('Judul / Penanggung Jawab')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('publikasi')
                    ->label('Publikasi')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('identifikasi')
                    ->label('ISBN')
                    ->searchable(),
                Tables\Columns\TextColumn::make('klasifikasi')
                    ->label('Klasifikasi')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('subjek')
                    ->label('Subjek')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('isbn_submission_id')
                    ->label('Sumber')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-document-text')
                    ->trueColor('success')
                    ->falseColor('gray')
                    ->tooltip(fn ($record) => $record->isbn_submission_id ? 'Sistem ISBN Baru' : 'Form Builder Lama')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('sumber')
                    ->label('Sumber Data')
                    ->options([
                        'isbn_baru' => 'Sistem ISBN Baru',
                        'form_lama' => 'Form Builder Lama',
                        'manual'    => 'Input Manual',
                    ])
                    ->query(function (Builder $query, array $data) {
                        return match($data['value'] ?? null) {
                            'isbn_baru' => $query->whereNotNull('isbn_submission_id'),
                            'form_lama' => $query->whereNotNull('form_submission_id')->whereNull('isbn_submission_id'),
                            'manual'    => $query->whereNull('isbn_submission_id')->whereNull('form_submission_id'),
                            default     => $query,
                        };
                    }),
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
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKatalogBukus::route('/'),
            'create' => Pages\CreateKatalogBuku::route('/create'),
            'edit' => Pages\EditKatalogBuku::route('/{record}/edit'),
        ];
    }
}
