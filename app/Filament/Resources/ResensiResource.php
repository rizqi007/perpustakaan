<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ResensiResource\Pages;
use App\Models\Resensi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use AmidEsfahani\FilamentTinyEditor\TinyEditor;

class ResensiResource extends Resource
{
    protected static ?string $model = Resensi::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationGroup = 'Manajemen Web';

    protected static ?string $navigationLabel = 'Resensi';
    
    protected static ?string $modelLabel = 'Resensi';

    protected static ?string $pluralModelLabel = 'Resensi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Informasi Resensi')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Judul Resensi')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),

                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(Resensi::class, 'slug', ignoreRecord: true),

                                Forms\Components\TextInput::make('book_title')
                                    ->label('Judul Buku')
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('author')
                                            ->label('Penulis Buku')
                                            ->required()
                                            ->maxLength(255),
                                        
                                        Forms\Components\TextInput::make('reviewer_name')
                                            ->label('Nama Peresensi')
                                            ->required()
                                            ->maxLength(255),
                                    ]),

                                TinyEditor::make('content')
                                    ->label('Isi Resensi')
                                    ->profile('full')
                                    ->required()
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Status & Publikasi')
                            ->schema([
                                Forms\Components\Select::make('status')
                                    ->options([
                                        'draft' => 'Draft',
                                        'published' => 'Published',
                                        'archived' => 'Archived',
                                    ])
                                    ->required()
                                    ->default('draft'),

                                Forms\Components\DatePicker::make('published_at')
                                    ->label('Tanggal Terbit')
                                    ->default(now()),
                            ]),

                        Forms\Components\Section::make('Gambar Sampul')
                            ->schema([
                                Forms\Components\FileUpload::make('cover_image')
                                    ->label('Cover Buku')
                                    ->image()
                                    ->directory('resensi-covers')
                                    ->required(),
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')
                    ->label('Cover'),

                Tables\Columns\TextColumn::make('title')
                    ->label('Judul Resensi')
                    ->searchable()
                    ->sortable()
                    ->limit(50),

                Tables\Columns\TextColumn::make('book_title')
                    ->label('Judul Buku')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('reviewer_name')
                    ->label('Peresensi')
                    ->searchable(),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'published' => 'success',
                        'archived' => 'danger',
                    }),

                Tables\Columns\TextColumn::make('published_at')
                    ->label('Terbit')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'archived' => 'Archived',
                    ]),
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
            'index' => Pages\ListResensis::route('/'),
            'create' => Pages\CreateResensi::route('/create'),
            'edit' => Pages\EditResensi::route('/{record}/edit'),
        ];
    }
}
