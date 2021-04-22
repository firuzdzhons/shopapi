<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategory;
use App\Models\Category;

class CategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['jwt.auth', 'role:admin'])->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(
            Category::with('subcategories')->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategory $request)
    {
        try {
            $category = Category::create([
                'name' => $request->name,
                'description' => $request->description,
                'parent_id' => $request->parent_id
            ]);

            return response()->json(['message' => 'created', 'category' => $category]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 405);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCategory $request, $id)
    {
        //return $request;
        try {
            Category::where('id', $id)->update([
                'name' => $request->name,
                'description' => $request->description,
                'parent_id' => $request->parent_id
            ]);

            return response()->json(['message' => 'updated', 'category' => Category::find($id)]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 405);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
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
