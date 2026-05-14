<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFlavorRequest;
use App\Http\Requests\StoreRestaurantRequest;
use App\Models\Flavor;
use App\Models\Recipe;
use App\Models\Restaurant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Authorize every action against the 'admin' Gate.
     * Following docs/technical.md (Modul 6 standard) — no custom middleware.
     */
    private function authorizeAdmin(): void
    {
        Gate::authorize('admin');
    }

    // =========================================================================
    // FLAVORS — Master data CRUD
    // =========================================================================
    public function flavorsIndex(): View
    {
        $this->authorizeAdmin();
        $flavors = Flavor::withCount(['recipes', 'restaurants'])->latest()->paginate(15);
        return view('admin.flavors.index', compact('flavors'));
    }

    public function flavorsCreate(): View
    {
        $this->authorizeAdmin();
        return view('admin.flavors.create');
    }

    public function flavorsStore(StoreFlavorRequest $request): RedirectResponse
    {
        $this->authorizeAdmin();
        Flavor::create($request->validated());
        return redirect('/admin/flavors')->with('status', 'Flavor berhasil ditambahkan.');
    }

    public function flavorsEdit(Flavor $flavor): View
    {
        $this->authorizeAdmin();
        return view('admin.flavors.edit', compact('flavor'));
    }

    public function flavorsUpdate(StoreFlavorRequest $request, Flavor $flavor): RedirectResponse
    {
        $this->authorizeAdmin();
        $flavor->update($request->validated());
        return redirect('/admin/flavors')->with('status', 'Flavor diperbarui.');
    }

    public function flavorsDestroy(Flavor $flavor): RedirectResponse
    {
        $this->authorizeAdmin();
        $flavor->delete();
        return redirect('/admin/flavors')->with('status', 'Flavor dihapus.');
    }

    // =========================================================================
    // RESTAURANTS — CRUD with image upload
    // =========================================================================
    public function restaurantsIndex(): View
    {
        $this->authorizeAdmin();
        $restaurants = Restaurant::with('flavors')->latest()->paginate(12);
        return view('admin.restaurants.index', compact('restaurants'));
    }

    public function restaurantsCreate(): View
    {
        $this->authorizeAdmin();
        $flavors = Flavor::orderBy('name')->get();
        return view('admin.restaurants.create', compact('flavors'));
    }

    public function restaurantsStore(StoreRestaurantRequest $request): RedirectResponse
    {
        $this->authorizeAdmin();
        $data = $request->validated();
        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('restaurants', 'public');
        }

        $restaurant = Restaurant::create([
            'name'        => $data['name'],
            'description' => $data['description'],
            'address'     => $data['address'],
            'phone'       => $data['phone'] ?? null,
            'image'       => $imagePath,
        ]);

        $restaurant->flavors()->sync($data['flavors'] ?? []);

        return redirect('/admin/restaurants')->with('status', 'Restoran berhasil ditambahkan.');
    }

    public function restaurantsEdit(Restaurant $restaurant): View
    {
        $this->authorizeAdmin();
        $restaurant->load('flavors');
        $flavors = Flavor::orderBy('name')->get();
        return view('admin.restaurants.edit', compact('restaurant', 'flavors'));
    }

    public function restaurantsUpdate(StoreRestaurantRequest $request, Restaurant $restaurant): RedirectResponse
    {
        $this->authorizeAdmin();
        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($restaurant->image) {
                Storage::disk('public')->delete($restaurant->image);
            }
            $data['image'] = $request->file('image')->store('restaurants', 'public');
        }

        $restaurant->update([
            'name'        => $data['name'],
            'description' => $data['description'],
            'address'     => $data['address'],
            'phone'       => $data['phone'] ?? null,
            'image'       => $data['image'] ?? $restaurant->image,
        ]);

        $restaurant->flavors()->sync($data['flavors'] ?? []);

        return redirect('/admin/restaurants')->with('status', 'Restoran diperbarui.');
    }

    public function restaurantsDestroy(Restaurant $restaurant): RedirectResponse
    {
        $this->authorizeAdmin();
        if ($restaurant->image) {
            Storage::disk('public')->delete($restaurant->image);
        }
        $restaurant->delete();

        return redirect('/admin/restaurants')->with('status', 'Restoran dihapus.');
    }

    // =========================================================================
    // RECIPES — Listing + approval workflow
    // =========================================================================
    public function recipesIndex(Request $request): View
    {
        $this->authorizeAdmin();
        $status = $request->query('status');

        $query = Recipe::with(['user', 'flavors'])->latest();
        if (in_array($status, ['pending', 'approved', 'rejected'], true)) {
            $query->where('status', $status);
        }

        return view('admin.recipes.index', [
            'recipes' => $query->paginate(15)->withQueryString(),
            'status'  => $status,
        ]);
    }

    public function approvalsIndex(): View
    {
        $this->authorizeAdmin();
        $recipes = Recipe::with(['user', 'flavors'])
            ->where('status', 'pending')
            ->latest()
            ->paginate(10);

        return view('admin.approvals.index', compact('recipes'));
    }

    public function approveRecipe(Recipe $recipe): RedirectResponse
    {
        $this->authorizeAdmin();
        $recipe->update(['status' => 'approved']);
        return back()->with('status', "Resep \"{$recipe->title}\" disetujui.");
    }

    public function rejectRecipe(Recipe $recipe): RedirectResponse
    {
        $this->authorizeAdmin();
        $recipe->update(['status' => 'rejected']);
        return back()->with('status', "Resep \"{$recipe->title}\" ditolak.");
    }
}
