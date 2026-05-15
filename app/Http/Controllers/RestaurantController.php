<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\View\View;

class RestaurantController extends Controller
{
    // Halaman publik: daftar semua restoran
    public function index(): View
    {
        $restaurants = Restaurant::with(['flavors', 'reviews'])
            ->latest()
            ->paginate(12);

        return view('public.restaurants.index', compact('restaurants'));
    }

    // Halaman publik: detail satu restoran
    public function show(Restaurant $restaurant): View
    {
        $restaurant->load(['flavors', 'reviews.user']);

        $avgRating = $restaurant->reviews->avg('rating') ?? 0;

        return view('public.restaurants.show', compact('restaurant', 'avgRating'));
    }
}
