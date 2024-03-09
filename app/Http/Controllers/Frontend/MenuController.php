<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Laravel\Prompts\alert;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::paginate(5);

        return view('menus.index', compact('menus'));
    }

    public function store(Request $request , $id)
    {

        if (!Auth::check()) {
            return redirect()->back()->with('warning', 'You must be logged in to place an order.');
        }

        $user = Auth::user();

        $menuId = $id;

        try {
            $result = $user->menus()->attach($menuId);


            if ($result) {
                alert("no thing") ;

                return redirect()->back()->with('success', 'Menu item added to your order successfully!');
            } else {
                alert("no thing") ;

                return redirect()->back()->with('warning', 'Failed to add menu item to your order.');
            }
            return redirect()->back()->with('success', 'Menu item added to your order successfully!');
        } catch (\Exception $e) {
            alert("no thing") ;

            \Log::error('Error storing menu item: ' . $e->getMessage());

            // Return error message to user
            return redirect()->back()->with('warning', 'An unexpected error occurred. Please try again later.');
        }
    }

    function show(){

        $user = Auth::user() ;
        $menus = $user->menus->all() ;
        return view('items.index' , ['menus' => $menus , 'user' => $user] ) ;

    }

    public function destroy($id)
    {
        $user = Auth::user();

        // Find the menu item associated with the authenticated user
        $menu = $user->menus()->where('id', $id)->first();

        // Check if the menu item exists
        if ($menu) {
        // Detach the menu item from all associated categories

        // Detach the menu item from all associated users
        $menu->users()->detach($id);

        // Delete the menu item from the database


            return to_route('menus.index')->with('danger', 'Menu Item Deleted successfully');
        } else {
            return to_route('menus.index')->with('warning', 'Menu Item not found');
        }
    }

    public function increase($id, $count)
    {
        // Find the menu by id
        $menu = Menu::findOrFail($id);

        // Increment the count
        $menu->count = $count + 1;
        $menu->save();

        // Redirect back or to a specific route
        return redirect()->back();
    }
    public function decrease($id, $count)
    {
        // Find the menu by id
        $menu = Menu::findOrFail($id);

        // Increment the count
        $menu->count = $count - 1;
        $menu->save();

        // Redirect back or to a specific route
        return redirect()->back();
    }



}
