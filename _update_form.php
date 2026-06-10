<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$form = App\Models\Form::find(1);
if ($form) {
    $fields = $form->fields;
    foreach ($fields as $k => $f) {
        if ($f['label'] === 'Pilihan Waktu Nobar') {
            $fields[$k]['options'] = [
                '09:00 - 11:00 WIB' => '09:00 - 11:00 WIB',
                '13:00 - 15:00 WIB' => '13:00 - 15:00 WIB',
            ];
        }
    }
    $form->fields = $fields;
    $form->save();
    echo "Form updated successfully!\n";
} else {
    echo "Form not found.\n";
}
