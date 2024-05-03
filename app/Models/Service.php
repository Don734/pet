<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Whitecube\NovaFlexibleContent\Value\FlexibleCast;

class Service extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $table = 'services';

    protected $fillable = [
        'title',
        'description',
        'characteristics',
        'services',
        'price',
        'handbook_id',
    ];

    protected $casts = [
        'characteristics' => FlexibleCast::class,
        'services' => FlexibleCast::class,
    ];

    const types = [
        'room' => 'Комната'
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(350)
            ->height(350);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images')->useDisk('public');
    }

    public function handbook()
    {
        return $this->belongsTo(Handbook::class);
    }

    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }
}
