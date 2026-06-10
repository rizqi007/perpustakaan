<?php

namespace App\Traits;

use App\Models\TrashBin;

trait Trashable
{
    /**
     * Boot the trait.
     */
    protected static function bootTrashable()
    {
        static::deleting(function ($model) {
            // Automatically capture the record and move it to trash_bins
            TrashBin::moveToTrash($model);
        });
    }
}
