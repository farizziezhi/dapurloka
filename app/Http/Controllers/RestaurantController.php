<?php

namespace App\Http\Controllers;

use App\Models\Flavor;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RestaurantController extends Controller
{
    // Halaman publik: daftar semua restoran
    public function index(Request $request): View
    {
        // Ambil semua flavor untuk dropdown filter
        $flavors = Flavor::orderBy('name')->get();

        // Query dasar: eager load relasi yang dibutuhkan
        $query = Restaurant::with(['flavors', 'reviews']);

        // Filter berdasarkan pencarian nama
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan flavor (multiple)
        if ($request->filled('flavors')) {
            $flavorIds = (array) $request->flavors;
            $query->whereHas('flavors', function ($q) use ($flavorIds) {
                $q->whereIn('flavors.id', $flavorIds);
            });
        }

        // Urutkan terbaru, tampilkan 12 per halaman
        $restaurants = $query->latest()->paginate(12)->withQueryString();

        return view('public.restaurants.index', compact('restaurants', 'flavors'));
    }

    // Halaman publik: detail satu restoran
    public function show(Restaurant $restaurant): View
    {
        $restaurant->load(['flavors', 'reviews.user']);

        $avgRating = $restaurant->reviews->avg('rating') ?? 0;

        return view('public.restaurants.show', compact('restaurant', 'avgRating'));
    }
}
