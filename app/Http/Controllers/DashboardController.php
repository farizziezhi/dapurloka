<?php

namespace App\Http\Controllers;

use App\Models\Flavor;
use App\Models\Recipe;
use App\Models\RecipeReview;
use App\Models\Restaurant;
use App\Models\RestaurantReview;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /** Branch the dashboard view based on the authenticated user role. */
    public function index(Request $request): View
    {
        $user = $request->user();

        if ($user->isAdmin()) {
            return view('admin.dashboard', [
                'totalRecipes'     => Recipe::count(),
                'pendingRecipes'   => Recipe::where('status', 'pending')->count(),
                'approvedRecipes'  => Recipe::where('status', 'approved')->count(),
                'totalRestaurants' => Restaurant::count(),
                'totalFlavors'     => Flavor::count(),
                'recentPending'    => Recipe::with(['user', 'flavors'])
                    ->where('status', 'pending')
                    ->latest()
                    ->take(5)
                    ->get(),
            ]);
        }

        return view('user.dashboard', [
            'totalRecipes'        => Recipe::where('user_id', $user->id)->count(),
            'approvedRecipes'     => Recipe::where('user_id', $user->id)->where('status', 'approved')->count(),
            'pendingRecipes'      => Recipe::where('user_id', $user->id)->where('status', 'pending')->count(),
            'rejectedRecipes'     => Recipe::where('user_id', $user->id)->where('status', 'rejected')->count(),
            'totalRecipeReviews'  => RecipeReview::where('user_id', $user->id)->count(),
            'totalRestoReviews'   => RestaurantReview::where('user_id', $user->id)->count(),
            'recentRecipes'       => Recipe::with(['flavors', 'reviews'])
                ->where('user_id', $user->id)
                ->latest()
                ->take(4)
                ->get(),
        ]);
    }
}
