<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Recipe extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'ingredients',
        'steps',
        'image',
        'status',
    ];

    // ---------- Scopes ----------
    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', 'approved');
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    // ---------- Relationships ----------
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function flavors(): BelongsToMany
    {
        return $this->belongsToMany(Flavor::class, 'flavor_recipe');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(RecipeReview::class);
    }
}
