<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRecipeRequest;
use App\Models\Flavor;
use App\Models\Recipe;
use App\Models\RecipeReview;
use App\Models\RestaurantReview;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class UserRecipeController extends Controller
{
    /** Authorize against the 'user' Gate. Modul 6 standard, no custom middleware. */
    private function authorizeUser(): void
    {
        Gate::authorize('user');
    }

    /** Ensure the authenticated user owns the recipe. */
    private function ensureOwner(Recipe $recipe): void
    {
        abort_if($recipe->user_id !== auth()->id(), 403);
    }

    /** "My Recipes" listing. */
    public function index(): View
    {
        $this->authorizeUser();

        $recipes = Recipe::with(['flavors', 'reviews'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('user.my-recipes.index', compact('recipes'));
    }

    public function create(): View
    {
        $this->authorizeUser();
        $flavors = Flavor::orderBy('name')->get();
        return view('user.my-recipes.create', compact('flavors'));
    }

    public function store(StoreRecipeRequest $request): RedirectResponse
    {
        $this->authorizeUser();
        $data = $request->validated();
        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('recipes', 'public');
        }

        $recipe = Recipe::create([
            'user_id'     => auth()->id(),
            'title'       => $data['title'],
            'ingredients' => $data['ingredients'],
            'steps'       => $data['steps'],
            'image'       => $imagePath,
            'status'      => 'pending', // PRD: User-submitted recipes default to pending.
        ]);

        $recipe->flavors()->sync($data['flavors'] ?? []);

        return redirect('/my/recipes')->with('status', 'Resep terkirim. Menunggu persetujuan admin.');
    }

    public function edit(Recipe $recipe): View
    {
        $this->authorizeUser();
        $this->ensureOwner($recipe);

        $recipe->load('flavors');
        $flavors = Flavor::orderBy('name')->get();

        return view('user.my-recipes.edit', compact('recipe', 'flavors'));
    }

    public function update(StoreRecipeRequest $request, Recipe $recipe): RedirectResponse
    {
        $this->authorizeUser();
        $this->ensureOwner($recipe);

        $data = $request->validated();

        if ($request->hasFile('image')) {
            if ($recipe->image) {
                Storage::disk('public')->delete($recipe->image);
            }
            $data['image'] = $request->file('image')->store('recipes', 'public');
        }

        $recipe->update([
            'title'       => $data['title'],
            'ingredients' => $data['ingredients'],
            'steps'       => $data['steps'],
            'image'       => $data['image'] ?? $recipe->image,
            // Editing an approved/rejected recipe sends it back to pending review.
            'status'      => 'pending',
        ]);

        $recipe->flavors()->sync($data['flavors'] ?? []);

        return redirect('/my/recipes')->with('status', 'Resep diperbarui. Menunggu peninjauan ulang.');
    }

    public function destroy(Recipe $recipe): RedirectResponse
    {
        $this->authorizeUser();
        $this->ensureOwner($recipe);

        if ($recipe->image) {
            Storage::disk('public')->delete($recipe->image);
        }
        $recipe->delete();

        return redirect('/my/recipes')->with('status', 'Resep dihapus.');
    }

    /** Review history for the current user. */
    public function reviews(): View
    {
        $this->authorizeUser();

        $recipeReviews = RecipeReview::with('recipe')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        $restaurantReviews = RestaurantReview::with('restaurant')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('user.my-reviews.index', compact('recipeReviews', 'restaurantReviews'));
    }
}
