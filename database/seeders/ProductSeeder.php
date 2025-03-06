<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            'Hoodies' => ['akatsuki_hoodie.jpeg', 'aot_hoodie.jpeg', 'jjk_hoodie.jpeg', 'kaneki_hoodie.jpeg'],
            'Windbreaker' => ['classic_windbreaker.jpeg', 'modern_windbreaker.jpeg', 'racing_windbreaker.jpeg', 'techware_windbreaker.jpeg', 'windbreaker.jpeg'],
            'Shoes' => ['shoes.jpeg', 'jordan1_shoes.jpeg', 'jordan4_shoes.jpeg', 'kobe6_shoes.jpeg', 'nb_shoes.jpeg'],
            'Shorts' => ['shorts.jpeg', 'cargo_shorts.jpeg', 'denim_shorts.jpeg', 'retro_shorts.jpeg', 'tailored_shorts.jpeg'],
            'Jackets' => ['jacket.jpeg', 'denim_jacket.jpeg', 'hybrid_jacket.jpeg', 'oversized_jacket.jpeg', 'puffer_jacket.jpeg'],
            'Accessories' => ['bag.jpeg', 'Basketball_accessories.jpeg', 'cap_accessories.jpeg', 'headbands_accessories.jpeg', 'sleeves_accessories.jpeg'],
        ];

        foreach ($products as $categoryName => $images) {
            $category = Category::where('name', $categoryName)->first();

            if ($category) {
                foreach ($images as $image) {
                    Product::create([
                        'category_id' => $category->id,
                        'name' => Str::replace('_', ' ', pathinfo($image, PATHINFO_FILENAME)), // Convert filename to name
                        'slug' => Str::slug(pathinfo($image, PATHINFO_FILENAME)),
                        'image' => 'storage/public/' . $image,
                        'price' => fake()->randomFloat(2, 20, 200), // Random price between $20-$200
                        'description' => fake()->sentence(10),
                        'stock' => fake()->numberBetween(5, 50),
                    ]);
                }
            }
        }
    }
}
