<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryStoreRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all() ;
        return view('admin.categories.index' , ['categories' => $categories]) ;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create' ) ;

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreRequest $request)
    {
        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('images'), $imageName);
        $category = new Category();
        $category->name = $request->name;
        $category->description = $request->description;

        $category->image = $imageName;
        $category->save();
        return to_route('admin.categories.index')->with('success','Category Created Successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
      return view ('admin.categories.edit', ['category'=>$category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
     // Validate the request data
    $request->validate([
        "name" => "required",
        "description" => "required",
        "image" => "image|mimes:jpeg,png,jpg,gif|max:2048" // Validation rule for image file
    ]);

    // Update the category data
    $category->name = $request->name;
    $category->description = $request->description;

    // Check if a new image is uploaded
    if ($request->hasFile('image')) {
        // Store the new image and update the image path
        $imagePath = $request->file('image')->store('public/images');
        $category->image = $imagePath;
    }

    $category->save();

    return redirect()->route('admin.categories.index')->with('warning','Category Updated Successfully');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index')->with('danger','Category Deleted Successfully');
    }
}
