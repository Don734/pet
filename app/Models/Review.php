<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $table = 'reviews';

    protected $fillable = [
        'name',
        'comment',
        'rating',
        'client_id',
        'is_published',
        'reviewable_type',
        'reviewable_id',
    ];

    public function reviewable()
    {
        return $this->morphTo();
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopePublishedAndUnpublished($query)
{
    return $query->withoutGlobalScope('published');
}

    public function getStarRatingAttribute()
    {
        $stars = '';

        for ($i = 1; $i <= $this->rating; $i++) {
            $stars .= '★';
        }

        return $stars;
    }
}
