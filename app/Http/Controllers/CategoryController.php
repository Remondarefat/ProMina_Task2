<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('media')->get(); 
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
         // Retrieve categories that do not have a parent
        $categories = Category::whereNull('parent_id')->get();
        return view('categories.create', compact('categories'));    
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'desc' => 'nullable|string',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'parent_id' => 'nullable|exists:categories,id',

        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->desc = $request->desc;
        $category->parent_id = $request->parent_id; 
        $category->save();

        // Handle icon upload
        if ($request->hasFile('icon')) {
            $category->addMediaFromRequest('icon')
                ->toMediaCollection('icon');
        }
        //    Handle image upload
    if ($request->hasFile('img')) {
        $category->addMediaFromRequest('img')->toMediaCollection('img');
    }
    // dd($request);

        return redirect()->route('categories.index')->with('success', 'Category created successfully');
    }
    public function edit(Category $category)
    {
        // Retrieve categories that do not have a parent
        $categories = Category::whereNull('parent_id')->where('id', '!=', $category->id)->get();
        return view('categories.edit', compact('category', 'categories'));
    }
    

public function update(Request $request, Category $category)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'desc' => 'nullable|string',
        'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'parent_id' => 'nullable|exists:categories,id',
    ]);

    $category->name = $request->name;
    $category->desc = $request->desc;
    $category->parent_id = $request->parent_id;

    // Handle icon update
    if ($request->hasFile('icon')) {
        // Delete old icon if exists
        $category->clearMediaCollection('icon');
        $category->addMediaFromRequest('icon')->toMediaCollection('icon');
    }

    // Handle image update
    if ($request->hasFile('img')) {
        // Delete old image if exists
        $category->clearMediaCollection('img');
        $category->addMediaFromRequest('img')->toMediaCollection('img');
    }

    $category->save();

    return redirect()->route('categories.index')->with('success', 'Category updated successfully');
}


public function destroy(Category $category)
{
    // Delete category and associated media
    $category->delete();

    return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
}


}





