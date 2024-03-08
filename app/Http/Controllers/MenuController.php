<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\MenuStoreRequest;


use App\Models\User;
use Illuminate\Support\Facades\DB; // Import the DB facade







class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all() ;
        $menus = Menu::all() ;
        return view('admin.menus.index' , ['menus' => $menus , "users" => $users ] ) ;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.menus.create', compact('categories') ) ;

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MenuStoreRequest $request)
    {

        // Move image file to public/images directory
        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('images'), $imageName);

        // Create a new menu item instance
        $menu = new Menu();
        $menu->name = $request->name;
        $menu->description = $request->description;
        $menu->price = $request->price;
        $menu->image = $imageName;

        // Begin database transaction
        DB::beginTransaction();

        try {



            // Check if request has categories and attach them to the menu item

            $menu->save();

            if ($request->has('categories')) {
                $menu->categories()->attach($request->categories);
            }


            // Commit the transaction
            DB::commit();

            // Redirect to the index page with success message
            return redirect()->route('admin.menus.index')->with('success', 'Menu Item Added successfully');
        } catch (\Exception $e) {
            // Rollback the transaction in case of error
            DB::rollback();

            // Log the error or handle it appropriately
            // For now, let's just return the error message

            DB::commit();

            return redirect()->route('admin.menus.index')->with('success', 'Menu Item Added successfully');
        } catch (\Exception $e) {
            DB::rollback();


            return back()->with('error', 'Failed to add menu item: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {


        return to_route('userItems');

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
        if($request->has('categories')){
            $menu->categories()->sync($request->categories);
        }

        $menu->save();

        return redirect()->route('admin.menus.index')->with('warning', 'Menu Item Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();

        return redirect()->route('admin.menus.index')->with('danger', 'Menu Item Deleted successfully');
    }
    public function active($id)
    {
        $menu = Menu::findOrFail($id);

        $menu->update(['state' => '1']);

        return redirect()->route('admin.menus.index')->with('success', 'Menu Item Activated successfully');
    }



}
