<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Log; // ✅ Add logging

class ProductService
{
    public function getAll()
    {
        // ✅ Fetch products with media (Paginated)
        $products = Product::with(['category', 'media'])->paginate();

        return $products->through(function ($product) {
            // ✅ Fetch the image URL using Spatie
            $imageUrl = $product->getFirstMediaUrl('images');

            // ✅ Log the product name and the image URL
            Log::info("Product: {$product->name}, Image URL: " . ($imageUrl ?: 'NULL'));

            return [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => number_format($product->price, 2),
                'description' => $product->description,
                'stock' => $product->stock,
                'category' => $product->category->name ?? null,
                'image' => !empty($imageUrl) ? $imageUrl : null, // ✅ Ensure it returns a valid URL
                'media_id' => $product->media_id,
                'created_at' => $product->created_at,
                'updated_at' => $product->updated_at,
            ];
        });
    }
}
