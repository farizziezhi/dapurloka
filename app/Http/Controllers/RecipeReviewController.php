<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\RecipeReview;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RecipeReviewController extends Controller
{
    /** Store a new review for a recipe. */
    public function store(Request $request, Recipe $recipe): RedirectResponse
    {
        // Hanya resep approved yang boleh di-review
        abort_if($recipe->status !== 'approved', 404);

        $data = $request->validate([
            'rating'  => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        // Tidak boleh review resep milik sendiri
        if ($recipe->user_id === auth()->id()) {
            return back()->with('error', 'Kamu tidak bisa mengulas resep milikmu sendiri.');
        }

        // Cek duplikat: 1 user = 1 review per resep
        $existing = RecipeReview::where('user_id', auth()->id())
            ->where('recipe_id', $recipe->id)
            ->exists();

        if ($existing) {
            return back()->with('error', 'Kamu sudah pernah memberikan ulasan untuk resep ini.');
        }

        RecipeReview::create([
            'user_id'   => auth()->id(),
            'recipe_id' => $recipe->id,
            'rating'    => $data['rating'],
            'comment'   => $data['comment'],
        ]);

        return back()->with('status', 'Ulasan berhasil dikirim!');
    }

    /** Delete own review. */
    public function destroy(Recipe $recipe, RecipeReview $review): RedirectResponse
    {
        abort_if($review->user_id !== auth()->id(), 403);

        $review->delete();

        return back()->with('status', 'Ulasan dihapus.');
    }
}
