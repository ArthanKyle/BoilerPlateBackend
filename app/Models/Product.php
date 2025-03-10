<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['name', 'slug', 'price', 'category_id', 'description', 'stock']; // ✅ Removed `media_id`

    protected $appends = ['image_url']; // ✅ Ensure `image_url` is included in API response

    // ✅ MUST BE PUBLIC (Spatie requirement)
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images')->useDisk('public');
    }

    // ✅ Get the image URL from Spatie Media Library
    public function getImageUrlAttribute()
    {
        return $this->getFirstMediaUrl('images') ?: null;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
