<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;

class HandbooksCategory extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    public function handbooks()
    {
        return $this->belongsTo(Handbook::class, 'handbook_id');
    }
}
