<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Manajemen User';

    protected static ?string $navigationLabel = 'Pengguna';

    protected static ?string $modelLabel = 'Pengguna';

    protected static ?string $pluralModelLabel = 'Pengguna';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('role')
                    ->options([
                        'user' => 'User',
                        'admin' => 'Admin',
                        'superadmin' => 'Superadmin',
                    ])
                    ->required()
                    ->default('user'),
                Forms\Components\TextInput::make('satuan_kerja')
                    ->maxLength(255)
                    ->label('Satuan Kerja'),
                Forms\Components\TextInput::make('no_hp')
                    ->maxLength(20)
                    ->label('No. HP'),
                Forms\Components\FileUpload::make('surat_tugas')
                    ->label('Surat Tugas')
                    ->disk('public')
                    ->directory('surat_tugas')
                    ->openable()
                    ->downloadable()
                    ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png', 'image/jpg'])
                    ->maxSize(2048),
                Forms\Components\Toggle::make('is_validated')
                    ->label('Tervalidasi')
                    ->default(false),
                Forms\Components\DateTimePicker::make('email_verified_at'),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->dehydrateStateUsing(fn ($state) => filled($state) ? bcrypt($state) : null)
                    ->required(fn (string $context): bool => $context === 'create')
                    ->maxLength(255)
                    ->dehydrated(fn ($state) => filled($state)),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('role')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'user' => 'info',
                        'admin' => 'warning',
                        'superadmin' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('satuan_kerja')
                    ->searchable()
                    ->sortable()
                    ->label('Satuan Kerja')
                    ->limit(30)
                    ->tooltip(fn ($state) => $state),
                Tables\Columns\TextColumn::make('no_hp')
                    ->searchable()
                    ->label('No. HP'),
                Tables\Columns\TextColumn::make('surat_tugas')
                    ->label('Surat Tugas')
                    ->formatStateUsing(fn ($state) => $state ? 'Unduh Surat' : '-')
                    ->action(fn ($record) => $record->surat_tugas ? \Illuminate\Support\Facades\Storage::disk('public')->download($record->surat_tugas) : null)
                    ->color('primary')
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('is_online')
                    ->label('Status')
                    ->getStateUsing(fn ($record) => $record->isOnline() ? 'Online' : 'Offline')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'Online' ? 'success' : 'gray'),
                Tables\Columns\ToggleColumn::make('is_validated')
                    ->label('Validasi'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->options([
                        'user' => 'User',
                        'admin' => 'Admin',
                        'superadmin' => 'Superadmin',
                    ]),
                Tables\Filters\TernaryFilter::make('is_validated')
                    ->label('Status Validasi')
                    ->placeholder('Semua Pengguna')
                    ->trueLabel('Tervalidasi')
                    ->falseLabel('Menunggu Validasi'),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
    
    public static function getNavigationGroup(): ?string
    {
        return 'Manajemen User';
    }
}
