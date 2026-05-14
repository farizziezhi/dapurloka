<?php

namespace App\Http\Controllers;

use App\Ai\Agents\CulinaryAgent;
use App\Models\Recipe;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /** Public landing page with AI hero, featured recipes, and top restaurants. */
    public function index(): View
    {
        $featuredRecipes = Recipe::approved()
            ->with(['user', 'flavors', 'reviews'])
            ->latest()->take(6)->get();

        $topRestaurants = Restaurant::with(['flavors', 'reviews'])
            ->latest()->take(6)->get();

        return view('public.home', compact('featuredRecipes', 'topRestaurants'));
    }

    /** AI suggestion based on user condition; agent returns picks as cards. */
    public function aiSuggest(Request $request)
    {
        $request->validate(['prompt' => ['required', 'string', 'max:500']]);

        $recipes     = Recipe::approved()->with(['user', 'flavors', 'reviews'])->latest()->take(20)->get();
        $restaurants = Restaurant::with(['flavors', 'reviews'])->latest()->take(20)->get();

        try {
            $response = CulinaryAgent::make()->prompt(
                "Kondisi pengguna: \"{$request->prompt}\".

                Daftar resep tersedia (id | judul | flavor):
                {$recipes->map(fn ($r) => "{$r->id} | {$r->title} | ".$r->flavors->pluck('name')->implode(', '))->implode("\n")}

                Daftar restoran tersedia (id | nama | flavor):
                {$restaurants->map(fn ($r) => "{$r->id} | {$r->name} | ".$r->flavors->pluck('name')->implode(', '))->implode("\n")}

                Pilih maksimal 3 resep dan 3 restoran yang paling cocok. Kembalikan hanya ID dari daftar di atas."
            );
        } catch (\Throwable $e) {
            return back()->withInput()->with('error', 'Dapur AI sedang sibuk, coba beberapa saat lagi.');
        }

        return view('public.ai-result', [
            'prompt'      => $request->prompt,
            'intro'       => $response['intro']   ?? null,
            'closing'     => $response['closing'] ?? null,
            'recipes'     => $recipes->whereIn('id',     $response['recipe_ids']     ?? [])->values(),
            'restaurants' => $restaurants->whereIn('id', $response['restaurant_ids'] ?? [])->values(),
        ]);
    }
}
