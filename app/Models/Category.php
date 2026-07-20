<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'emoji',
        'description',
        'seo_title',
        'seo_description',
        'og_title',
        'og_description',
        'og_image',
        'noindex'
    ];

    protected $casts = [
        'noindex' => 'boolean',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
