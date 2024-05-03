<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Client extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable;
    use InteractsWithMedia;
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'password',
        'type',
        'confirmation_token',
        'confirmed'
    ];

    public function handbooks()
    {
        return $this->hasMany(Handbook::class);
    }
}
