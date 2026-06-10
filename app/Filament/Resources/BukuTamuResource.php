<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BukuTamuResource\Pages;
use App\Filament\Resources\BukuTamuResource\RelationManagers;
use App\Models\BukuTamu;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BukuTamuResource extends Resource
{
    protected static ?string $model = BukuTamu::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    
    protected static ?string $navigationGroup = 'Formulir';
    protected static ?string $navigationLabel = 'Data Pengunjung';
    protected static ?string $pluralModelLabel = 'Data Pengunjung';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('institusi')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('institusi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Kunjungan')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    \pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction::make()->exports([
                        \pxlrbt\FilamentExcel\Exports\ExcelExport::make('csv')
                            ->fromTable()
                            ->withFilename('Data_Pengunjung_' . date('Ymd'))
                            ->withWriterType(\Maatwebsite\Excel\Excel::CSV)
                            ->label('Export CSV'),
                        \pxlrbt\FilamentExcel\Exports\ExcelExport::make('pdf')
                            ->fromTable()
                            ->withFilename('Data_Pengunjung_' . date('Ymd'))
                            ->withWriterType(\Maatwebsite\Excel\Excel::DOMPDF)
                            ->label('Export PDF'),
                    ])->label('Export Terpilih')->icon('heroicon-o-arrow-down-tray'),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\VisitorChart::class,
        ];
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
            'index' => Pages\ListBukuTamus::route('/'),
            'create' => Pages\CreateBukuTamu::route('/create'),
            'edit' => Pages\EditBukuTamu::route('/{record}/edit'),
        ];
    }
}
