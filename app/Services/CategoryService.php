<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    public function getAll()
    {
        $categories = Category::with('media')->paginate();

        return $categories->map(function ($category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug,
                'image' => url($category->getFirstMediaUrl('images'))

            ];
        });
    }
}
