<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveProduct;
use App\Models\Category;
use App\Models\Product;

class ProductsController extends Controller
{
    public function index()
    {
       return response()->json(
           Product::paginate(20)
       );    
    }

    public function store(SaveProduct $request){
        try {
            $product =Product::create([
                'name' => $request->name,
                'category_id' => $request->category_id,
                'description' => $request->description,
                'price' => $request->price
            ]);

            return response()->json(['message' => 'created', 'product' => $product]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 405);
        }
    }

    public function update(SaveProduct $request, Product $product)
    {
        try {
            $product->update([
                'name' => $request->name,
                'category_id' => $request->category_id,
                'description' => $request->description,
                'price' => $request->price
            ]);

            return response()->json(['message' => 'updated', 'category' => $product->refresh()]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 405);
        }
    }
    
    public function destroy(Product $product)
    {
        try {
            $product->delete();

            return response()->json(['message' => 'deleted']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 405);
        }
    }
}
