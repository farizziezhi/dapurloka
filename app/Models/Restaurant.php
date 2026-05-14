<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Restaurant extends Model
{
    protected $fillable = [
        'name',
        'description',
        'address',
        'phone',
        'image',
    ];

    public function flavors(): BelongsToMany
    {
        return $this->belongsToMany(Flavor::class, 'flavor_restaurant');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(RestaurantReview::class);
    }
}
