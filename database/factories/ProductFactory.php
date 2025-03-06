<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        // Define categories and their corresponding images
        $products = [
            'Hoodies' => ['akatsuki_hoodie.jpeg', 'aot_hoodie.jpeg', 'jjk_hoodie.jpeg', 'kaneki_hoodie.jpeg'],
            'Windbreaker' => ['classic_windbreaker.jpeg', 'modern_windbreaker.jpeg', 'racing_windbreaker.jpeg', 'techware_windbreaker.jpeg', 'windbreaker.jpeg'],
            'Shoes' => ['shoes.jpeg', 'jordan1_shoes.jpeg', 'jordan4_shoes.jpeg', 'kobe6_shoes.jpeg', 'nb_shoes.jpeg'],
            'Shorts' => ['shorts.jpeg', 'cargo_shorts.jpeg', 'denim_shorts.jpeg', 'retro_shorts.jpeg', 'tailored_shorts.jpeg'],
            'Jackets' => ['jacket.jpeg', 'denim_jacket.jpeg', 'hybrid_jacket.jpeg', 'oversized_jacket.jpeg', 'puffer_jacket.jpeg'],
            'Accessories' => ['bag.jpeg', 'Basketball_accessories.jpeg', 'cap_accessories.jpeg', 'headbands_accessories.jpeg', 'sleeves_accessories.jpeg'],
        ];

        // Pick a random category
        $categoryName = $this->faker->randomElement(array_keys($products));
        
        // Get the correct category ID
        $category = Category::where('name', $categoryName)->first();
        $categoryId = $category ? $category->id : null;

        // Pick a random product from the category
        $image = $this->faker->randomElement($products[$categoryName]);
        
        return [
            'category_id' => $categoryId,
            'name' => Str::replace('_', ' ', pathinfo($image, PATHINFO_FILENAME)), // Convert filename to product name
            'slug' => Str::slug(pathinfo($image, PATHINFO_FILENAME)),
            'image' => 'storage/public/' . $image,
            'price' => $this->faker->randomFloat(2, 20, 200), // Random price between $20 and $200
            'description' => $this->faker->sentence(10),
            'stock' => $this->faker->numberBetween(5, 50),
        ];
    }
}
