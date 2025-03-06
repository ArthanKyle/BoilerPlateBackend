<?php 

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        $categories = [
            'Hoodies' => 'akatsuki_hoodie.jpeg',
            'Windbreaker' => 'classic_windbreaker.jpeg',
            'Shoes' => 'shoes.jpeg',
            'Shorts' => 'shorts.jpeg',
            'Jackets' => 'jacket.jpeg',
            'Accessories' => 'bag.jpeg',
        ];

        $name = $this->faker->randomElement(array_keys($categories));

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'image' => 'storage/public/' . $categories[$name], // Corrected storage path
        ];
    }
}
