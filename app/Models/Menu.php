<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  App\Models\Category;
use App\Models\User;

class Menu extends Model
{
    use HasFactory;
    protected $fillable = ['name','price','description','image' ,'state'];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_menu');
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_menu');
    }
}
