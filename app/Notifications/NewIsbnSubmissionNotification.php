<?php

namespace App\Notifications;

use App\Models\IsbnSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewIsbnSubmissionNotification extends Notification
{
    use Queueable;

    public function __construct(public IsbnSubmission $submission)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return \Filament\Notifications\Notification::make()
            ->title('Pengajuan ISBN Baru')
            ->body("Pengajuan ISBN baru dari {$this->submission->author} - \"{$this->submission->title}\"")
            ->icon('heroicon-o-document-text')
            ->warning()
            ->getDatabaseMessage();
    }
}
