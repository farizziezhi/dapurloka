<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ---------- Default Accounts ----------
        User::updateOrCreate(
            ['email' => 'admin@dapurloka.test'],
            [
                'name' => 'Admin Dapurloka',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@dapurloka.test'],
            [
                'name' => 'Demo User',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        );

        $this->call([
            FlavorSeeder::class,
            RestaurantSeeder::class,
            RecipeSeeder::class,
        ]);
    }
}
