<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Flavor extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public function recipes(): BelongsToMany
    {
        return $this->belongsToMany(Recipe::class, 'flavor_recipe');
    }

    public function restaurants(): BelongsToMany
    {
        return $this->belongsToMany(Restaurant::class, 'flavor_restaurant');
    }
}
