<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Facades\File;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $jsonPath = database_path('seeders/data/categories.json');

        if (!File::exists($jsonPath)) {
            echo "❌ Error: categories.json not found!\n";
            return;
        }

        $categories = json_decode(File::get($jsonPath), true);

        foreach ($categories as $category) {
            // Create or update category
            $newCategory = Category::updateOrCreate(
                ['slug' => $category['slug']],
                ['name' => $category['name'], 'media_id' => null] // Placeholder
            );

            // Attach image using Spatie Media Library
            $imagePath = storage_path("app/public/" . $category['image']);
            if (file_exists($imagePath)) {
                $newCategory->clearMediaCollection('images');
                $media = $newCategory->addMedia($imagePath)
                    ->preservingOriginal()
                    ->toMediaCollection('images');

                // ✅ Store media ID in `categories` table
                $newCategory->update(['media_id' => $media->id]);
            } else {
                echo "❌ Image not found: {$category['image']}\n";
            }
        }

        echo "✅ Categories seeded successfully!\n";
    }
}
