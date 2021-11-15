<?php

namespace App\Models;

use App\Models\Traits\HasChildren;
use App\Models\Traits\isOrderable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\SlugOptions;
use Spatie\Sluggable\HasSlug;

class Category extends Model
{
    use HasSlug, HasChildren, isOrderable, HasFactory;

    protected $fillable = [
        'name',
        'description',
        'slug',
        'category_id',
    ];


    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function childCategories()
    {
        return $this->hasMany(Category::class, 'category_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
