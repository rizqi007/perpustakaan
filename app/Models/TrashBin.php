<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TrashBin extends Model
{
    protected $fillable = [
        'model_type',
        'model_id',
        'label',
        'payload',
        'deleted_by',
    ];

    protected $casts = [
        'payload' => 'array',
    ];

    /**
     * Move a model instance to the trash bin.
     */
    public static function moveToTrash(Model $model): self
    {
        // Try to automatically find a descriptive field for the listing display
        $label = null;
        foreach (['title', 'label', 'name', 'judul', 'nama', 'username', 'email'] as $field) {
            if (isset($model->{$field})) {
                $label = $model->{$field};
                break;
            }
        }

        if (!$label) {
            $label = class_basename($model) . ' #' . $model->getKey();
        }

        // Identify who performed the deletion
        $user = Auth::user();
        $deletedBy = $user ? ($user->name . ' (' . $user->email . ')') : 'Sistem / Tamu';

        return self::create([
            'model_type' => get_class($model),
            'model_id' => $model->getKey(),
            'label' => $label,
            'payload' => $model->getAttributes(), // Get raw DB attributes
            'deleted_by' => $deletedBy,
        ]);
    }
}
