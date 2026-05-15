<?php

namespace App\Http\Controllers;

use App\Ai\Agents\RecipeDescriptionAgent;
use App\Models\Flavor;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RecipeController extends Controller
{
    // Halaman publik: daftar semua resep yang admin acc
    public function index(Request $request): View
    {
        // Ambil semua flavor untuk dropdown filter
        $flavors = Flavor::orderBy('name')->get();

        // Query dasar: hanya resep approved, eager load relasi yang dibutuhkan
        $query = Recipe::approved()
            ->with(['user', 'flavors', 'reviews']);

        // Filter berdasarkan pencarian judul
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Filter berdasarkan flavor (multiple)
        if ($request->filled('flavors')) {
            $flavorIds = (array) $request->flavors;
            $query->whereHas('flavors', function ($q) use ($flavorIds) {
                $q->whereIn('flavors.id', $flavorIds);
            });
        }

        // Urutkan terbaru, tampilkan 12 per halaman
        $recipes = $query->latest()->paginate(12)->withQueryString();

        return view('public.recipes', compact('recipes', 'flavors'));
    }

    // Halaman publik: detail satu resep
    public function show(Recipe $recipe): View
    {
        abort_if($recipe->status !== 'approved', 404);

        $recipe->load(['user', 'flavors', 'reviews.user']);

        $avgRating = $recipe->reviews->avg('rating') ?? 0;

        return view('public.recipe-detail', compact('recipe', 'avgRating'));
    }

    // Generate deskripsi AI on-demand (dipanggil via POST button)
    public function generateDescription(Recipe $recipe)
    {
        abort_if($recipe->status !== 'approved', 404);

        $recipe->load('flavors');
        $flavors = $recipe->flavors->pluck('name')->implode(', ');

        try {
            $response = RecipeDescriptionAgent::make()->prompt(
                "Buatkan deskripsi untuk resep '{$recipe->title}' dengan bahan: {$recipe->ingredients}. Flavor: {$flavors}."
            );
            $aiDescription = trim($response->text);
        } catch (\Throwable $e) {
            return back()->with('error', 'Dapur AI sedang sibuk, coba lagi sebentar.');
        }

        return back()->with('aiDescription', $aiDescription);
    }
}