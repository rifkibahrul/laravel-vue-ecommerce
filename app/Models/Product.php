<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Product extends Model
{
    use HasFactory;
    use HasSlug;
    use SoftDeletes;

    // protected $fillable = ['title', 'description', 'price', 'image', 'published', 'image_mime', 'image_size', 'created_by', 'updated_by'];
    protected $fillable = ['title', 'description', 'price', 'images', 'published', 'created_by', 'updated_by'];
    protected $casts = [
        'images' => 'array',
    ];

    // Get first image for product
    public function getFirstImageAttribute()   // getFirstImageAttribute() → $product->first_image
    {
        if ($this->images && is_array($this->images) && count($this->images) > 0) {
            return $this->images[0]['url'];
        }
        return $this->image; // fallback to single image field
    }

    // Get all image
    public function getAllImagesAttribute()
    {
        if (!empty($this->images) && is_array($this->images)) {
            return array_map(function ($image) {
                return $image['url'];
            }, $this->images);
        }
        return [$this->image]; // Fallback jika tidak ada gambar
    }


    protected $appends = ['first_image', 'all_images'];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
