<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserRecipeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\RestaurantController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/ai/suggest', [HomeController::class, 'aiSuggest'])->name('ai.suggest');
Route::get('/recipes', [RecipeController::class, 'index'])->name('recipes.index');
Route::get('/recipes/{recipe}', [RecipeController::class, 'show'])->name('recipes.show');

Route::get('/restaurants', [RestaurantController::class, 'index'])->name('restaurants.index');
Route::get('/restaurants/{restaurant}', [RestaurantController::class, 'show'])->name('restaurants.show');

/*
|--------------------------------------------------------------------------
| Manual Auth Routes (no Breeze/Jetstream/Fortify)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Authenticated Routes (Gate-protected per controller method)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Shared dashboard entry point. The controller branches by role.
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /*
    |----------------------------------------------------------------------
    | Admin (Gate::authorize('admin') inside AdminController)
    |----------------------------------------------------------------------
    */
    Route::prefix('admin')->group(function () {
        // Flavors
        Route::get('flavors',                 [AdminController::class, 'flavorsIndex'])->name('admin.flavors.index');
        Route::get('flavors/create',          [AdminController::class, 'flavorsCreate'])->name('admin.flavors.create');
        Route::post('flavors',                [AdminController::class, 'flavorsStore'])->name('admin.flavors.store');
        Route::get('flavors/{flavor}/edit',   [AdminController::class, 'flavorsEdit'])->name('admin.flavors.edit');
        Route::put('flavors/{flavor}',        [AdminController::class, 'flavorsUpdate'])->name('admin.flavors.update');
        Route::delete('flavors/{flavor}',     [AdminController::class, 'flavorsDestroy'])->name('admin.flavors.destroy');

        // Restaurants
        Route::get('restaurants',                     [AdminController::class, 'restaurantsIndex'])->name('admin.restaurants.index');
        Route::get('restaurants/create',              [AdminController::class, 'restaurantsCreate'])->name('admin.restaurants.create');
        Route::post('restaurants',                    [AdminController::class, 'restaurantsStore'])->name('admin.restaurants.store');
        Route::get('restaurants/{restaurant}/edit',   [AdminController::class, 'restaurantsEdit'])->name('admin.restaurants.edit');
        Route::put('restaurants/{restaurant}',        [AdminController::class, 'restaurantsUpdate'])->name('admin.restaurants.update');
        Route::delete('restaurants/{restaurant}',     [AdminController::class, 'restaurantsDestroy'])->name('admin.restaurants.destroy');

        // Recipes & Approvals
        Route::get('recipes',                         [AdminController::class, 'recipesIndex'])->name('admin.recipes.index');
        Route::get('approvals',                       [AdminController::class, 'approvalsIndex'])->name('admin.approvals.index');
        Route::post('recipes/{recipe}/approve',       [AdminController::class, 'approveRecipe'])->name('admin.recipes.approve');
        Route::post('recipes/{recipe}/reject',        [AdminController::class, 'rejectRecipe'])->name('admin.recipes.reject');
    });

    /*
    |----------------------------------------------------------------------
    | User Workspace (Gate::authorize('user') inside UserRecipeController)
    |----------------------------------------------------------------------
    */
    Route::prefix('my')->group(function () {
        Route::get('recipes',                  [UserRecipeController::class, 'index'])->name('my.recipes.index');
        Route::get('recipes/create',           [UserRecipeController::class, 'create'])->name('my.recipes.create');
        Route::post('recipes',                 [UserRecipeController::class, 'store'])->name('my.recipes.store');
        Route::get('recipes/{recipe}/edit',    [UserRecipeController::class, 'edit'])->name('my.recipes.edit');
        Route::put('recipes/{recipe}',         [UserRecipeController::class, 'update'])->name('my.recipes.update');
        Route::delete('recipes/{recipe}',      [UserRecipeController::class, 'destroy'])->name('my.recipes.destroy');

        Route::get('reviews',                  [UserRecipeController::class, 'reviews'])->name('my.reviews.index');

        Route::get('profile',                  [ProfileController::class, 'edit'])->name('my.profile.edit');
        Route::put('profile',                  [ProfileController::class, 'update'])->name('my.profile.update');
    });
});
