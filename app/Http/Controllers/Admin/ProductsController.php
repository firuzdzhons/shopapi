<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProduct;
use App\Http\Requests\UpdateProduct;
use App\Http\Resources\ProductResource;
use App\Models\Product;

class ProductsController extends Controller
{
    public function index()
    {
       return ProductResource::collection(
           Product::paginate(20)
       );    
    }

    public function store(CreateProduct $request){
        try {
            $product = Product::create([
                'name' => $request->name,
                'category_id' => $request->category_id,
                'description' => $request->description,
                'price' => $request->price
            ]);

            $product->addMedia($request->image)->toMediaCollection();

            return response()->json(['message' => 'created', 'product' => new ProductResource($product)]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 405);
        }
    }

    public function update(UpdateProduct $request, Product $product)
    {
        try {
            $product->update([
                'name' => $request->name,
                'category_id' => $request->category_id,
                'description' => $request->description,
                'price' => $request->price
            ]);

            if ($request->hasFile('new_image') && $product->getFirstMedia()) {
                $product->getFirstMedia()->delete();
                $product->addMedia($request->new_image)->toMediaCollection();
            }

            return response()->json(['message' => 'updated', 'category' => new ProductResource($product->refresh())]);
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
