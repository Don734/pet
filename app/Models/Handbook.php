<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Whitecube\NovaFlexibleContent\Value\FlexibleCast;

class Handbook extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $table = 'handbooks';

    protected $casts = [
        'service_prices' => 'collection',
        'services' => FlexibleCast::class,
        'tags' => 'array',
    ];

    protected $fillable = [
        'title',
        'description',
        'price',
        'address',
        'characteristics',
        'phone',
        'seller',
        'service_prices',
        'coord_x',
        'coord_y',
        'working_hours',
        'client_id',
        'slug',
        'tags',
        'popular',
        'category_id',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(350)
            ->height(350)
            ->format(Manipulations::FORMAT_WEBP);

        $this->addMediaConversion('retina')
            ->width(700)
            ->height(700)
            ->format(Manipulations::FORMAT_WEBP);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images')->useDisk('public');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function scopePopular($query)
    {
        return $query->where('popular', true);
    }

    public function averageRating()
    {
        return $this->reviews()->published()->avg('rating');
    }

    public function categories()
{
    return $this->belongsToMany(Category::class, 'handbooks_categories', 'handbook_id', 'category_id');
}

    public function handbooksCategories()
    {
        return $this->hasMany(HandbooksCategory::class);
    }
}

