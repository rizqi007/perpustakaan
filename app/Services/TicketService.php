<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\FormSubmission;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TicketService
{
    public function generateAndReturnPath(FormSubmission $submission)
    {
        // 1. Initialize Image Manager (GD Driver)
        $manager = new ImageManager(new Driver());

        // 2. Load Background Image
        $form = $submission->form;
        $bgPath = public_path('images/ticket-bg.jpg');
        
        if ($form && $form->ticket_bg_image && Storage::disk('public')->exists($form->ticket_bg_image)) {
             $image = $manager->read(Storage::disk('public')->path($form->ticket_bg_image));
        } elseif (file_exists($bgPath)) {
            $image = $manager->read($bgPath);
        } else {
            // Create a placeholder canvas if no background exists
            $image = $manager->create(800, 300)->fill('eeeeee');
        }

        // Resize/Cover removed to allow original size
        // $image->cover(800, 300);

        // 3. Prepare Data
        $name = data_get($submission->data, 'Nama') ?? data_get($submission->data, 'Name') ?? 'Guest';
        $bookingDate = $submission->booking_date ? $submission->booking_date->format('d M Y') : 'Date N/A';
        $time = data_get($submission->data, 'Pilihan Waktu Nobar') ?? 'Time N/A'; // Adjust key if needed

        // 4. Resolve Font Path
        $fontPath = public_path('fonts/arial.ttf');
        if (!file_exists($fontPath)) {
            // Fallback to Windows system font for local dev
            $fontPath = 'C:/Windows/Fonts/arial.ttf';
        }

        // 5. Overlay Text (Name)
        $nameX = $form->ticket_name_x ?? 60;
        $nameSize = $form->ticket_name_size ?? 32;
        $nameColor = $form->ticket_name_color ?? '#000000';
        $gdNameSize = $nameSize * 0.75; 
        $nameY = ($form->ticket_name_y ?? 145) + ($nameSize * 0.2); 

        $image->text($name, $nameX, $nameY, function ($font) use ($fontPath, $gdNameSize, $nameColor) {
            if (file_exists($fontPath)) {
                $font->file($fontPath);
            }
            $font->size($gdNameSize);
            $font->color($nameColor);
            $font->align('left');
            $font->valign('top');
        });

        // 6. Overlay Text (Date & Time)
        $dateX = $form->ticket_date_x ?? 60;
        $dateSize = $form->ticket_date_size ?? 20;
        $dateColor = $form->ticket_date_color ?? '#333333';
        $gdDateSize = $dateSize * 0.75;
        $dateY = ($form->ticket_date_y ?? 200) + ($dateSize * 0.2);

        $image->text($bookingDate . ' | ' . $time, $dateX, $dateY, function ($font) use ($fontPath, $gdDateSize, $dateColor) {
             if (file_exists($fontPath)) {
                $font->file($fontPath);
            }
            $font->size($gdDateSize);
            $font->color($dateColor);
            $font->align('left');
            $font->valign('top');
        });

        // 7. Save Image to Storage
        $filename = 'ticket-' . $submission->id . '-' . Str::random(8) . '.jpg';
        $path = 'tickets/' . $filename;
        
        Storage::disk('public')->put($path, $image->toJpeg());

        return $path;
    }
}
