<?php

namespace App\Filament\Resources\TestimoniResource\Pages;

use App\Filament\Resources\TestimoniResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class ViewTestimoni extends ViewRecord
{
    protected static string $resource = TestimoniResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Informasi Testimoni')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('name')
                                    ->label('Nama'),
                                Infolists\Components\TextEntry::make('institution')
                                    ->label('Instansi/Pekerjaan'),
                            ]),
                        
                        Infolists\Components\TextEntry::make('quote')
                            ->label('Testimoni')
                            ->columnSpanFull(),
                    ]),

                Infolists\Components\Section::make('Media')
                    ->schema([
                        Infolists\Components\ImageEntry::make('photo')
                            ->label('Foto')
                            ->disk('public')
                            ->height(200)
                            ->visibility('public'),
                        
                        Infolists\Components\TextEntry::make('video')
                            ->label('Video')
                            ->formatStateUsing(function ($state) {
                                if (!$state) return 'Tidak ada video';
                                
                                $url = asset('storage/' . $state);
                                return new \Illuminate\Support\HtmlString(
                                    "<video controls style='max-width: 100%; height: auto;'>
                                        <source src='{$url}' type='video/mp4'>
                                        Browser tidak mendukung video.
                                    </video>"
                                );
                            }),
                        
                        Infolists\Components\TextEntry::make('youtube_url')
                            ->label('YouTube URL')
                            ->formatStateUsing(function ($state) {
                                if (!$state) return 'Tidak ada YouTube URL';
                                
                                // Extract YouTube ID
                                $pattern = '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i';
                                if (preg_match($pattern, $state, $match)) {
                                    $embedUrl = 'https://www.youtube.com/embed/' . $match[1];
                                    return new \Illuminate\Support\HtmlString(
                                        "<iframe width='100%' height='315' src='{$embedUrl}' frameborder='0' allowfullscreen></iframe>"
                                    );
                                }
                                
                                return $state;
                            }),
                    ])
                    ->columns(1),

                Infolists\Components\Section::make('Informasi Sistem')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('created_at')
                                    ->label('Dibuat')
                                    ->dateTime('d F Y, H:i'),
                                Infolists\Components\TextEntry::make('updated_at')
                                    ->label('Diperbarui')
                                    ->dateTime('d F Y, H:i'),
                            ]),
                    ])
                    ->collapsible(),
            ]);
    }
}