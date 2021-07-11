<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategory;
use Illuminate\Support\Str;
use App\Models\Category;


class CategoriesController extends Controller
{
    public function index()
    {
       return response()->json(
           Category::get()
       );    
    }

    public function store(StoreCategory $request)
    {
        try {
            $category = Category::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'order'=> $request->order, 
                'parent_id' => $request->parent_id
            ]);

            return response()->json(['message' => 'created', 'category' => $category]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 405);
        }
    }

    public function update(StoreCategory $request, Category $category)
    {
        try {
            $category->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'order'=> $request->order, 
                'parent_id' => $request->parent_id
            ]);

            return response()->json(['message' => 'updated', 'category' => $category->refresh()]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 405);
        }
    }

    public function destroy(Category $category)
    {
        try {
            $category->delete();

            return response()->json(['message' => 'deleted']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 405);
        }
    }
}
