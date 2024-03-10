<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\MenuStoreRequest;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        $menus = Menu::all();
        return view('admin.menus.index', compact('menus', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.menus.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MenuStoreRequest $request)
    {
        try {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);

            $menu = new Menu();
            $menu->name = $request->name;
            $menu->description = $request->description;
            $menu->price = $request->price;
            $menu->image = $imageName;
            $menu->save();

            if ($request->has('categories')) {
                $menu->categories()->attach($request->categories);
            }

            return redirect()->route('admin.menus.index')->with('success', 'Menu Item Added successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to add menu item: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        return redirect()->route('userItems'); // Assuming 'userItems' is a valid route name
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        $categories = Category::all();
        return view('admin.menus.edit', compact('menu', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $menu->name = $request->name;
            $menu->description = $request->description;
            $menu->price = $request->price;

            if ($request->hasFile('image')) {
                $imageName = time() . '.' . $request->image->extension();
                $request->image->move(public_path('images'), $imageName);
                $menu->image = $imageName;
            }


            if ($request->has('categories')) {
                $menu->categories()->sync($request->categories);
            }

            $menu->save();

            return redirect()->route('admin.menus.index')->with('success', 'Menu Item Updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update menu item: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        // Detach relationships from user_menu table
        $menu->users()->detach(); // Assuming users() is the relationship to user_menu table
        
        // Detach relationships from category_menu table
        $menu->categories()->detach(); // Assuming categories() is the relationship to category_menu table
    
        // Delete the menu
        $menu->delete();
    
        return redirect()->route('admin.menus.index')->with('danger', 'Menu Deleted Successfully');
    }
    



    /**
     * Activate the specified menu item.
     */

    public function active($id)
    {
        try {
            $menu = Menu::findOrFail($id);
            $menu->update(['state' => '1']);

            return redirect()->route('admin.menus.index')->with('success', 'Menu Item Activated successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to activate menu item: ' . $e->getMessage());
        }
    }

}
