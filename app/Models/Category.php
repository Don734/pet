<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Category extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;
    use NodeTrait;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'slug',
        'description'
    ];

    public function handbooks()
    {
        return $this->hasMany(Handbook::class);
    }

    public function handbooksCategories()
    {
        return $this->hasMany(HandbooksCategory::class);
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(100)
            ->height(100);
    }

    // Определение поля, используемого для отображения в ресурсе Nova
    public function getKeyName()
    {
        return 'id';
    }

    // Отношение к родительской категории
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // Отношение к дочерним категориям (подкатегориям)
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
