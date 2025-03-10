<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $jsonPath = database_path('seeders/data/products.json');

        if (!File::exists($jsonPath)) {
            echo "❌ Error: products.json not found!\n";
            return;
        }

        $products = json_decode(File::get($jsonPath), true);

        foreach ($products as $productData) {
            // Find the correct category ID
            $category = Category::where('name', $productData['category'])->first();

            if ($category) {
                $product = Product::updateOrCreate(
                    ['slug' => $productData['slug']], // Prevent duplicate entries
                    [
                        'category_id' => $category->id,
                        'name' => $productData['name'],
                        'slug' => $productData['slug'],
                        'price' => $productData['price'],
                        'description' => $productData['description'],
                        'stock' => $productData['stock'],
                        'media_id' => null, // Placeholder for media ID
                    ]
                );

                // Attach image using Spatie Media Library
                $imagePath = storage_path("app/public/" . $productData['image']);
                if (File::exists($imagePath)) {
                    // Remove previous images
                    $product->clearMediaCollection('images');

                    // Add new media and get the media ID
                    $media = $product->addMedia($imagePath)
                        ->preservingOriginal()
                        ->toMediaCollection('images');

                    // ✅ Update the `media_id` in the `products` table
                    $product->update(['media_id' => $media->id]);

                    echo "✅ Image added: {$productData['image']} for product: {$productData['name']}\n";
                } else {
                    echo "❌ Image not found: {$productData['image']}\n";
                }
            } else {
                echo "❌ Category '{$productData['category']}' not found in database!\n";
            }
        }

        echo "✅ Products seeded successfully!\n";
    }
}
