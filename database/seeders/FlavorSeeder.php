<?php

namespace Database\Seeders;

use App\Models\Flavor;
use Illuminate\Database\Seeder;

class FlavorSeeder extends Seeder
{
    public function run(): void
    {
        $flavors = [
            ['name' => 'Pedas',   'description' => 'Cita rasa cabai dan rempah panas.'],
            ['name' => 'Manis',   'description' => 'Dominan rasa gula atau buah.'],
            ['name' => 'Asin',    'description' => 'Karakter gurih dan asin yang kuat.'],
            ['name' => 'Gurih',   'description' => 'Umami dari kaldu dan rempah.'],
            ['name' => 'Asam',    'description' => 'Segar dengan sentuhan asam.'],
            ['name' => 'Hangat',  'description' => 'Cocok dimakan saat dingin atau kurang sehat.'],
            ['name' => 'Asia',    'description' => 'Sajian khas Asia, termasuk Indonesia, dengan rempah dan bumbu tradisional.'],
            ['name' => 'Western', 'description' => 'Sajian gaya Barat seperti fast food, steak, dan masakan Eropa.'],
        ];

        foreach ($flavors as $flavor) {
            Flavor::updateOrCreate(['name' => $flavor['name']], $flavor);
        }
    }
}
