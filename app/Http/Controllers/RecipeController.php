<?php

// ============================================================
// FILE BARU — dibuat untuk halaman publik daftar resep
// Tugas: menampilkan semua resep yang sudah approved
// ============================================================

namespace App\Http\Controllers;

use App\Models\Flavor;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RecipeController extends Controller
{
    //Halaman publik: daftar semua resep yang admin acc
    public function index(Request $request): View
    {
     // Pastikan hanya resep approved yang bisa diakses publik
    abort_if($recipe->status !== 'approved', 404);

    // Load semua relasi yang dibutuhkan di halaman detail
    $recipe->load(['user', 'flavors', 'reviews.user']);

    // Hitung rata-rata rating
    $avgRating = $recipe->reviews->avg('rating') ?? 0;

    return view('public.recipe-detail', compact('recipe', 'avgRating'));
}
    
{
        // Ambil semua flavor untuk dropdown filter
        $flavors = Flavor::orderBy('name')->get();

        // Query dasar: hanya resep approved, eager load relasi yang dibutuhkan
        $query = Recipe::approved()
            ->with(['user', 'flavors', 'reviews']);

        // Filter berdasarkan pencarian judul (opsional)
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan flavor (opsional)
        if ($request->filled('flavor')) {
            $query->whereHas('flavors', function ($q) use ($request) {
                $q->where('flavors.id', $request->flavor);
            });
        }

        // Urutkan terbaru, tampilkan 12 per halaman
        $recipes = $query->latest()->paginate(12)->withQueryString();

        return view('public.recipes', compact('recipes', 'flavors'));
    }
}