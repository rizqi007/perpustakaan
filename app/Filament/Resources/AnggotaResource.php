<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AnggotaResource\Pages;
use App\Models\Anggota;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Notifications\Notification;

class AnggotaResource extends Resource
{
    protected static ?string $model = Anggota::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Anggota';

    protected static ?string $navigationGroup = 'Manajemen User';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'pending')->count() ?: null;
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Pribadi')
                    ->schema([
                        Forms\Components\FileUpload::make('foto')
                            ->image()
                            ->directory('anggota-fotos')
                            ->maxSize(2048)
                            ->nullable()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('nama')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('gender')
                            ->label('Jenis Kelamin')
                            ->options([
                                'Laki-laki' => 'Laki-laki',
                                'Perempuan' => 'Perempuan',
                            ])
                            ->required(),
                        Forms\Components\DatePicker::make('birth_date')
                            ->label('Tanggal Lahir')
                            ->required(),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('no_hp')
                            ->label('No. HP')
                            ->maxLength(20),
                        Forms\Components\TextInput::make('no_faks')
                            ->label('No. Faks')
                            ->maxLength(20),
                        Forms\Components\TextInput::make('institusi')
                            ->maxLength(255),
                        Forms\Components\Textarea::make('alamat')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('alamat_surat')
                            ->label('Alamat Surat')
                            ->rows(3)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('kode_pos')
                            ->label('Kode Pos')
                            ->maxLength(20),
                    ])->columns(2),

                Forms\Components\Section::make('Keanggotaan SLiMS')
                    ->schema([
                        Forms\Components\TextInput::make('nip')
                            ->label('ID Anggota / NIP')
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('NIP diisi oleh anggota saat mendaftar.')
                            ->default(null),
                        Forms\Components\Select::make('member_type_id')
                            ->label('Tipe Keanggotaan')
                            ->options(function() {
                                try {
                                    return \Illuminate\Support\Facades\DB::connection('slims')
                                        ->table('mst_member_type')
                                        ->pluck('member_type_name', 'member_type_id')
                                        ->toArray();
                                } catch (\Exception $e) {
                                    return [1 => 'Standard'];
                                }
                            })
                            ->required(),
                        Forms\Components\DatePicker::make('member_since_date')
                            ->label('Anggota Sejak')
                            ->default(now())
                            ->required(),
                        Forms\Components\DatePicker::make('register_date')
                            ->label('Tanggal Registrasi')
                            ->default(now())
                            ->required(),
                        Forms\Components\DatePicker::make('expire_date')
                            ->label('Berlaku Hingga')
                            ->default(now()->addYear())
                            ->required(),
                        Forms\Components\Toggle::make('is_pending')
                            ->label('Tunda Keanggotaan')
                            ->helperText('Tanggguhkan keanggotaan sementara di SLiMS.')
                            ->default(false),
                        Forms\Components\Textarea::make('catatan')
                            ->label('Catatan Keanggotaan')
                            ->rows(2)
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Persetujuan / Verifikasi')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'approved' => 'Disetujui',
                                'rejected' => 'Ditolak',
                            ])
                            ->default('pending')
                            ->required(),
                        Forms\Components\Textarea::make('catatan_admin')
                            ->label('Catatan Admin')
                            ->rows(2)
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\ImageColumn::make('foto')
                    ->circular()
                    ->defaultImageUrl(fn () => 'https://ui-avatars.com/api/?background=d1fae5&color=059669&name=A'),
                Tables\Columns\TextColumn::make('nip')
                    ->label('NIP')
                    ->searchable()
                    ->copyable()
                    ->placeholder('Belum ada'),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('gender')
                    ->label('Jenis Kelamin')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('birth_date')
                    ->label('Tanggal Lahir')
                    ->date('d M Y')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('institusi')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Menunggu',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Daftar')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('approved_at')
                    ->label('Tanggal Disetujui')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Menunggu',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                    ]),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('approve')
                        ->label('Setujui')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Setujui Anggota')
                        ->modalDescription(fn (Anggota $record) => "Apakah Anda yakin ingin menyetujui pendaftaran \"{$record->nama}\" dengan NIP \"{$record->nip}\"?")
                        ->visible(fn (Anggota $record) => $record->isPending())
                        ->action(function (Anggota $record) {
                            $record->update([
                                'status' => 'approved',
                                'approved_at' => now(),
                            ]);

                            Notification::make()
                                ->title('Anggota Disetujui')
                                ->body("NIP: {$record->nip}")
                                ->success()
                                ->send();
                        }),
                    Tables\Actions\Action::make('reject')
                        ->label('Tolak')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading('Tolak Pendaftaran')
                        ->form([
                            Forms\Components\Textarea::make('catatan_admin')
                                ->label('Alasan Penolakan')
                                ->required()
                                ->rows(3),
                        ])
                        ->visible(fn (Anggota $record) => $record->isPending())
                        ->action(function (Anggota $record, array $data) {
                            $record->update([
                                'status' => 'rejected',
                                'catatan_admin' => $data['catatan_admin'],
                            ]);

                            Notification::make()
                                ->title('Pendaftaran Ditolak')
                                ->danger()
                                ->send();
                        }),
                    Tables\Actions\Action::make('sync_slims')
                        ->label('Sinkronisasi SLiMS')
                        ->icon('heroicon-o-arrow-path')
                        ->color('info')
                        ->visible(fn (Anggota $record) => $record->isApproved())
                        ->action(function (Anggota $record) {
                            try {
                                \App\Services\SlimsSyncService::sync($record);
                                Notification::make()
                                    ->title('Sinkronisasi Berhasil')
                                    ->body("Anggota \"{$record->nama}\" berhasil disinkronkan ke SLiMS.")
                                    ->success()
                                    ->send();
                            } catch (\Exception $e) {
                                Notification::make()
                                    ->title('Sinkronisasi Gagal')
                                    ->body($e->getMessage())
                                    ->danger()
                                    ->send();
                            }
                        }),
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAnggotas::route('/'),
            'create' => Pages\CreateAnggota::route('/create'),
            'edit' => Pages\EditAnggota::route('/{record}/edit'),
        ];
    }
}
