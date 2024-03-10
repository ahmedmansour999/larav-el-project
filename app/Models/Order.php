<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Menu;



class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function menus(){

        return $this->belongsToMany(Menu::class, 'order_menu');

    }


}
