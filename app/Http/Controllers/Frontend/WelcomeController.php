<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Menu;

use Illuminate\Support\Facades\Auth;




class WelcomeController extends Controller
{
    public function index()
    {   
        if (Auth::check()) {
            $user_id = Auth::user()->id;
            $user_name = Auth::user()->name;
        } else {
            $please = 'please sign in';
            $user_id = null; 
            $user_name = null; 
        }

        $menus = Menu::all() ;
        $specials = Category::where('name', 'specials')->first();

        return view('welcome', compact('user_name','user_id') )->with('specials', $specials )->with('menus',$menus);
    }
    public function thankyou()
    {
        return view('thankyou');
    }
}
