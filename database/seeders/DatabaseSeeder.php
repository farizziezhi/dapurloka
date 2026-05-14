<?php

namespace Database\Seeders;

use App\Models\Flavor;
use App\Models\Recipe;
use App\Models\Restaurant;
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
        $admin = User::updateOrCreate(
            ['email' => 'admin@dapurloka.test'],
            [
                'name' => 'Admin Dapurloka',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        $user = User::updateOrCreate(
            ['email' => 'user@dapurloka.test'],
            [
                'name' => 'Demo User',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        );

        // ---------- Master Flavors ----------
        $flavors = collect([
            ['name' => 'Pedas',  'description' => 'Cita rasa cabai dan rempah panas.'],
            ['name' => 'Manis',  'description' => 'Dominan rasa gula atau buah.'],
            ['name' => 'Asin',   'description' => 'Karakter gurih dan asin yang kuat.'],
            ['name' => 'Gurih',  'description' => 'Umami dari kaldu dan rempah.'],
            ['name' => 'Asam',   'description' => 'Segar dengan sentuhan asam.'],
            ['name' => 'Hangat', 'description' => 'Cocok dimakan saat dingin atau kurang sehat.'],
        ])->mapWithKeys(function ($flavor) {
            $created = Flavor::updateOrCreate(['name' => $flavor['name']], $flavor);
            return [$flavor['name'] => $created->id];
        });

        // ---------- Sample Recipes (approved) ----------
        $recipeData = [
            [
                'title'       => 'Soto Ayam Bening',
                'ingredients' => "Ayam kampung\nBawang putih, kunyit, jahe\nSeledri, daun bawang\nSoun, kentang rebus\nJeruk nipis, sambal",
                'steps'       => "Tumis bumbu halus, masukkan air dan ayam.\nRebus hingga empuk lalu suwir ayam.\nSajikan dengan soun, kentang, dan kuah panas.",
                'flavors'     => ['Gurih', 'Hangat'],
            ],
            [
                'title'       => 'Bubur Ayam Lembut',
                'ingredients' => "Beras, kaldu ayam\nAyam suwir, kacang kedelai\nDaun bawang, kerupuk\nKecap manis, sambal",
                'steps'       => "Masak beras dengan kaldu hingga lembut.\nTaburi ayam suwir, kacang, dan kerupuk.\nSiram kecap manis sesuai selera.",
                'flavors'     => ['Gurih', 'Hangat'],
            ],
            [
                'title'       => 'Es Cendol Segar',
                'ingredients' => "Cendol hijau\nSantan, gula merah cair\nEs serut\nGaram sedikit",
                'steps'       => "Tata cendol di gelas.\nTuang santan dan gula merah.\nTambahkan es serut, sajikan dingin.",
                'flavors'     => ['Manis'],
            ],
            [
                'title'       => 'Tumis Kangkung Pedas',
                'ingredients' => "Kangkung segar\nBawang putih, cabai rawit\nTerasi, kecap ikan\nMinyak goreng",
                'steps'       => "Tumis bawang putih dan cabai hingga harum.\nMasukkan kangkung, aduk cepat.\nBumbui terasi dan kecap, sajikan panas.",
                'flavors'     => ['Pedas', 'Gurih'],
            ],
            [
                'title'       => 'Sayur Asem Jakarta',
                'ingredients' => "Kacang panjang, jagung manis\nLabu siam, melinjo\nAsam jawa, gula merah\nBawang merah, lengkuas",
                'steps'       => "Rebus bumbu hingga aromatik.\nMasukkan sayuran sesuai tingkat kekerasan.\nTambahkan asam jawa, koreksi rasa.",
                'flavors'     => ['Asam', 'Gurih'],
            ],
        ];

        foreach ($recipeData as $row) {
            $recipe = Recipe::updateOrCreate(
                ['title' => $row['title']],
                [
                    'user_id'     => $user->id,
                    'ingredients' => $row['ingredients'],
                    'steps'       => $row['steps'],
                    'status'      => 'approved',
                ]
            );

            $recipe->flavors()->sync(
                collect($row['flavors'])->map(fn ($name) => $flavors[$name])->all()
            );
        }

        // ---------- Sample Restaurants ----------
        $restaurantData = [
            [
                'name'        => 'Warung Sederhana',
                'description' => 'Warung tradisional dengan menu rumahan, cocok untuk makan siang ringan dan sehat.',
                'address'     => 'Jl. Diponegoro No. 12, Yogyakarta',
                'phone'       => '0274-555111',
                'flavors'     => ['Gurih', 'Hangat'],
            ],
            [
                'name'        => 'Sambal Bu Rini',
                'description' => 'Spesialis ayam geprek dan sambal rumahan yang pedasnya nampol.',
                'address'     => 'Jl. Kaliurang KM 5, Yogyakarta',
                'phone'       => '0274-555222',
                'flavors'     => ['Pedas'],
            ],
            [
                'name'        => 'Es Buah Pak Tirta',
                'description' => 'Tempat nongkrong sore dengan beragam es buah dan minuman segar khas Jawa.',
                'address'     => 'Jl. Malioboro No. 88, Yogyakarta',
                'phone'       => '0274-555333',
                'flavors'     => ['Manis', 'Asam'],
            ],
            [
                'name'        => 'Soto Kudus Pak Yono',
                'description' => 'Soto kuah bening hangat dengan ayam suwir, cocok untuk yang sedang flu atau cuaca dingin.',
                'address'     => 'Jl. Solo No. 45, Yogyakarta',
                'phone'       => '0274-555444',
                'flavors'     => ['Gurih', 'Hangat'],
            ],
        ];

        foreach ($restaurantData as $row) {
            $restaurant = Restaurant::updateOrCreate(
                ['name' => $row['name']],
                [
                    'description' => $row['description'],
                    'address'     => $row['address'],
                    'phone'       => $row['phone'],
                ]
            );

            $restaurant->flavors()->sync(
                collect($row['flavors'])->map(fn ($name) => $flavors[$name])->all()
            );
        }
    }
}
