<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchTag extends Model
{
    use HasFactory;

    protected $table = 'search_tags';

    protected $fillable = [
        'name'
    ];
}
