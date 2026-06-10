<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;
use App\Traits\Trashable;

class KlipingDigital extends Model
{
    use LogsActivity, Trashable;
    protected $fillable = [
        'title',
        'author',
        'source',
        'topic',
        'page_number',
        'published_at',
        'url',
        'image',
        'tanggal',
        'bulan',
        'tahun',
    ];

    protected $casts = [
        'published_at' => 'date',
    ];

    protected static function booted()
    {
        static::saving(function ($model) {
            if ($model->tanggal && $model->bulan && $model->tahun) {
                $bulanMap = [
                    'Januari' => 1, 'Februari' => 2, 'Maret' => 3, 'April' => 4,
                    'Mei' => 5, 'Juni' => 6, 'Juli' => 7, 'Agustus' => 8,
                    'September' => 9, 'Oktober' => 10, 'November' => 11, 'Desember' => 12,
                    'Jan' => 1, 'Feb' => 2, 'Mar' => 3, 'Apr' => 4,
                    'May' => 5, 'Jun' => 6, 'Jul' => 7, 'Aug' => 8,
                    'Sep' => 9, 'Oct' => 10, 'Nov' => 11, 'Dec' => 12,
                ];

                $bulanStr = $model->bulan;
                // Simple cleanup if needed, but assuming clean data based on user input
                
                $bulan = $bulanMap[$bulanStr] ?? 1;

                try {
                    $model->published_at = \Carbon\Carbon::createFromDate($model->tahun, $bulan, $model->tanggal);
                } catch (\Exception $e) {
                    $model->published_at = now();
                }
                
                unset($model->attributes['tanggal']);
                unset($model->attributes['bulan']);
                unset($model->attributes['tahun']);
            }
        });
    }
}
