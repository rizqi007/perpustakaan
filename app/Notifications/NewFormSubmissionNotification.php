<?php

namespace App\Notifications;

use App\Models\FormSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewFormSubmissionNotification extends Notification
{
    use Queueable;

    public function __construct(public FormSubmission $submission)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $formTitle = $this->submission->form?->title ?? 'Unknown Form';

        return \Filament\Notifications\Notification::make()
            ->title('Form Submission Baru')
            ->body("Formulir \"{$formTitle}\" baru saja diisi.")
            ->icon('heroicon-o-clipboard-document-list')
            ->info()
            ->getDatabaseMessage();
    }
}
