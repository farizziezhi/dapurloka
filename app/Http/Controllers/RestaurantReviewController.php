<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\RestaurantReview;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RestaurantReviewController extends Controller
{
    /** Store a new review for a restaurant. */
    public function store(Request $request, Restaurant $restaurant): RedirectResponse
    {
        $data = $request->validate([
            'rating'  => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        // Cek apakah user sudah pernah review restoran ini
        $existing = RestaurantReview::where('user_id', auth()->id())
            ->where('restaurant_id', $restaurant->id)
            ->exists();

        if ($existing) {
            return back()->with('error', 'Kamu sudah pernah memberikan ulasan untuk restoran ini.');
        }

        RestaurantReview::create([
            'user_id'       => auth()->id(),
            'restaurant_id' => $restaurant->id,
            'rating'        => $data['rating'],
            'comment'       => $data['comment'],
        ]);

        return back()->with('status', 'Ulasan berhasil dikirim!');
    }

    /** Delete own review. */
    public function destroy(Restaurant $restaurant, RestaurantReview $review): RedirectResponse
    {
        abort_if($review->user_id !== auth()->id(), 403);

        $review->delete();

        return back()->with('status', 'Ulasan dihapus.');
    }
}
