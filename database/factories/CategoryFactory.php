<?php 

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        static $usedCategories = [];

        $categories = [
            'Hoodies' => 'akatsuki_hoodie.jpeg',
            'Windbreaker' => 'classic_windbreaker.jpeg',
            'Shoes' => 'shoes.jpeg',
            'Shorts' => 'shorts.jpeg',
            'Jackets' => 'jacket.jpeg',
            'Accessories' => 'bag.jpeg',
        ];

         // Ensure a unique category is selected
    $availableCategories = array_diff(array_keys($categories), $usedCategories);
    
    if (empty($availableCategories)) {
        throw new \Exception('All category names have been used, cannot generate more unique categories.');
    }

        $name = $this->faker->randomElement($availableCategories);
        $usedCategories[] = $name; // Mark as used

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'image' => 'storage/public/' . $categories[$name], // Corrected storage path
        ];
    }
}
