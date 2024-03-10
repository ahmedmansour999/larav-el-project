<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\Reservation;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;
use App\Models\Menu;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'provider',
        'provider_id',
        'provider_token'
    ];


    public function menus()
    {
        return $this->belongsToMany(Menu::class, 'user_menu');
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function generateUserName($username = null)
    {
        if ($username === null) {
            $username = Str::lower(Str::random(8));
        }

        if (User::where('username', $username)->exists()) {
            $newUserName = $username . Str::lower(Str::random(3));
            $username = $this->generateUserName($newUserName);
        }

        return $username;
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'menu_order');
    }
}
