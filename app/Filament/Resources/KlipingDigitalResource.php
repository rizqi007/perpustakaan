<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KlipingDigitalResource\Pages;
use App\Filament\Resources\KlipingDigitalResource\RelationManagers;
use App\Models\KlipingDigital;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KlipingDigitalResource extends Resource
{
    protected static ?string $model = KlipingDigital::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';

    protected static ?string $navigationGroup = 'Layanan Digital';

    protected static ?string $navigationLabel = 'Kliping Digital';

    protected static ?string $modelLabel = 'Kliping Digital';

    protected static ?string $pluralModelLabel = 'Kliping Digital';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('author')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('source')
                    ->required()
                    ->maxLength(255)
                    ->label('Media Source'),
                Forms\Components\TextInput::make('topic')
                    ->maxLength(255)
                    ->label('Rubrik/Topic'),
                Forms\Components\TextInput::make('page_number')
                    ->maxLength(255),
                Forms\Components\DatePicker::make('published_at')
                    ->required(),
                Forms\Components\TextInput::make('url')
                    ->url()
                    ->maxLength(255)
                    ->label('External URL'),
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->directory('kliping-images'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('author')
                    ->searchable(),
                Tables\Columns\TextColumn::make('source')
                    ->searchable()
                    ->badge(),
                Tables\Columns\TextColumn::make('topic')
                    ->searchable(),
                Tables\Columns\TextColumn::make('published_at')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('published_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('source')
                    ->options(fn () => KlipingDigital::distinct()->pluck('source', 'source')->toArray()),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([
                Tables\Actions\Action::make('import')
                    ->label('Import Excel')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->color('success')
                    ->form([
                        Forms\Components\FileUpload::make('attachments')
                            ->label('Upload Excel Files')
                            ->acceptedFileTypes(['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel', 'text/csv'])
                            ->multiple()
                            ->required(),
                    ])
                    ->action(function (array $data) {
                        $files = $data['attachments'];
                        $count = 0;
                        \App\Imports\KlipingDigitalImport::$log = []; // Reset log
                        
                        foreach ($files as $filePath) {
                            $file = \Illuminate\Support\Facades\Storage::disk('public')->path($filePath);
                            
                            // Auto-detect settings
                            $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                            $delimiter = ';'; // Default
                            $headingRow = 2;  // Default for Excel with Title
                            
                            if (in_array($extension, ['csv', 'txt'])) {
                                try {
                                    $handle = fopen($file, 'r');
                                    $firstLine = fgets($handle);
                                    $secondLine = fgets($handle);
                                    fclose($handle);
                                    
                                    if ($firstLine) {
                                        // Detect delimiter
                                        $sc = substr_count($firstLine, ';');
                                        $c = substr_count($firstLine, ',');
                                        $delimiter = ($sc >= $c) ? ';' : ',';
                                        
                                        // Detect Header Row
                                        $row1 = str_getcsv($firstLine, $delimiter);
                                        $hasKeyword1 = false;
                                        foreach ($row1 as $cell) {
                                            if (stripos($cell, 'Tanggal') !== false || stripos($cell, 'Judul') !== false || stripos($cell, 'No') !== false) {
                                                $hasKeyword1 = true;
                                                break;
                                            }
                                        }
                                        
                                        if ($hasKeyword1) {
                                            $headingRow = 1;
                                        } else if ($secondLine) {
                                            $row2 = str_getcsv($secondLine, $delimiter);
                                            $hasKeyword2 = false;
                                            foreach ($row2 as $cell) {
                                                 if (stripos($cell, 'Tanggal') !== false || stripos($cell, 'Judul') !== false) {
                                                    $hasKeyword2 = true;
                                                    break;
                                                }
                                            }
                                            if ($hasKeyword2) $headingRow = 2;
                                        }
                                    }
                                } catch (\Exception $e) {
                                    // Ignore read errors, use defaults
                                }
                            }

                            try {
                                \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\KlipingDigitalImport($headingRow, $delimiter), $file);
                                $count++;
                                
                                // Delete file after import
                                \Illuminate\Support\Facades\Storage::disk('public')->delete($filePath);
                            } catch (\Exception $e) {
                                \Filament\Notifications\Notification::make()
                                    ->title('Import Failed for file: ' . basename($filePath))
                                    ->body($e->getMessage())
                                    ->danger()
                                    ->send();
                            }
                        }

                        if ($count > 0) {
                            \Filament\Notifications\Notification::make()
                                ->title('Import Process Completed')
                                ->body("Successfully imported {$count} files.")
                                ->success()
                                ->send();
                        }
                        
                        // Check for skipped rows
                        if (!empty(\App\Imports\KlipingDigitalImport::$log)) {
                            $logs = array_slice(\App\Imports\KlipingDigitalImport::$log, 0, 5); // Show first 5
                            $totalSkipped = count(\App\Imports\KlipingDigitalImport::$log);
                            
                            $advice = "";
                            // Check if keys look like data (contains integers or months)
                            $firstLog = $logs[0] ?? '';
                            if (str_contains($firstLog, 'Keys found [1, 2, januari') || str_contains($firstLog, 'Keys found [1, 2, 3')) {
                                $advice = "\n\n**Possible Fix:** It looks like the system is reading Data as Headers. Try changing 'Posisi Header' to 'Baris 1'.";
                            } elseif (str_contains($firstLog, 'Keys found') && count(explode(',', $firstLog)) < 3) {
                                $advice = "\n\n**Possible Fix:** It looks like the columns are not splitting. Try changing 'Pemisah Kolom' (Delimiter).";
                            }

                            \Filament\Notifications\Notification::make()
                                ->title("Warning: {$totalSkipped} Rows Skipped")
                                ->body(implode("\n", $logs) . ($totalSkipped > 5 ? "\n...and more." : "") . $advice)
                                ->warning()
                                ->persistent()
                                ->send();
                        }
                    }),
                Tables\Actions\Action::make('sync_google_sheet')
                    ->label('Sinkronisasi Google Sheet')
                    ->icon('heroicon-o-arrow-path')
                    ->color('warning')
                    ->form([
                        Forms\Components\TextInput::make('sheet_url')
                            ->label('Google Sheet CSV URL')
                            ->placeholder('https://docs.google.com/spreadsheets/d/.../export?format=csv')
                            ->helperText('Pastikan Google Sheet Anda telah dipublikasikan ke web: File -> Bagikan -> Publikasikan ke web -> Pilih format CSV -> Salin link URL.')
                            ->url()
                            ->required(),
                        Forms\Components\Toggle::make('clear_existing')
                            ->label('Kosongkan Data Lama?')
                            ->helperText('Aktifkan jika ingin menghapus seluruh data kliping digital yang ada di database sebelum melakukan sinkronisasi baru.')
                            ->default(false),
                    ])
                    ->action(function (array $data, \App\Filament\Resources\KlipingDigitalResource\Pages\ListKlipingDigitals $livewire) {
                        $url = trim($data['sheet_url']);
                        $clearExisting = $data['clear_existing'];
                        
                        // Auto-convert Google Sheet URLs to XLSX exports (supporting multiple sheets/tabs)
                        if (str_contains($url, '/edit')) {
                            $url = preg_replace('/\/edit(.*)/', '/export?format=xlsx', $url);
                        } elseif (str_contains($url, '/pubhtml')) {
                            $url = preg_replace('/\/pubhtml(.*)/', '/pub?output=xlsx', $url);
                        }
                        
                        $livewire->startSync($url, $clearExisting);
                    }),
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
            'index' => Pages\ListKlipingDigitals::route('/'),
            'create' => Pages\CreateKlipingDigital::route('/create'),
            'edit' => Pages\EditKlipingDigital::route('/{record}/edit'),
        ];
    }
}
