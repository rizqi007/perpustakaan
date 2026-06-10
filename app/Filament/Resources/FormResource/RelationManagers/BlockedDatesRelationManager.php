<?php

namespace App\Filament\Resources\FormResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BlockedDatesRelationManager extends RelationManager
{
    protected static string $relationship = 'BlockedDates';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('booking_date')
                    ->label('Tanggal')
                    ->required()
                    ->native(false)
                    ->displayFormat('d/m/Y'),
                
                Forms\Components\TextInput::make('session_time')
                    ->label('Waktu Sesi')
                    ->placeholder('Contoh: 09:00 - 10:30 WIB')
                    ->helperText('Kosongkan untuk memblokir seluruh hari'),
                
                Forms\Components\Textarea::make('reason')
                    ->label('Alasan')
                    ->placeholder('Contoh: Booked by Kemenag')
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('reason')
            ->columns([
                Tables\Columns\TextColumn::make('booking_date')
                    ->label('Tanggal')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('session_time')
                    ->label('Sesi')
                    ->placeholder('Seluruh Hari')
                    ->searchable(),
                Tables\Columns\TextColumn::make('reason')
                    ->label('Alasan')
                    ->limit(50),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}
