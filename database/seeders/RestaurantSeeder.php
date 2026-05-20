<?php

namespace Database\Seeders;

use App\Models\Flavor;
use App\Models\Restaurant;
use Illuminate\Database\Seeder;

class RestaurantSeeder extends Seeder
{
    public function run(): void
    {
        $flavors = Flavor::pluck('id', 'name');

        $restaurants = [
            [
                'name'        => 'Warung Makan Tembang Khas Kaili',
                'description' => 'Restoran seafood khas Kaili dengan kisaran harga Rp 25.000 – Rp 75.000. Cocok untuk pencinta hidangan laut bercita rasa lokal.',
                'address'     => 'Jl. Tembang No.23, Lere, Kec. Palu Bar., Kota Palu, Sulawesi Tengah 94111',
                'phone'       => '081234567890',
                'flavors'     => ['Asia', 'Gurih', 'Asin'],
            ],
            [
                'name'        => 'Mas Joko Sembunk',
                'description' => 'Warung makan sederhana di pusat kota Palu yang menyajikan menu khas Indonesia dengan harga ramah kantong.',
                'address'     => 'Jl. Rajamoili No.151, Besusu Bar., Kec. Palu Tim., Kota Palu, Sulawesi Tengah 94111',
                'phone'       => '082196929693',
                'flavors'     => ['Asia', 'Gurih'],
            ],
            [
                'name'        => 'Richeese Factory Sudirman Palu',
                'description' => 'Gerai fast food bergaya Western dengan menu ayam goreng saus keju pedas yang khas. Cocok untuk nongkrong maupun makan keluarga.',
                'address'     => 'Lolu Utara, Kec. Palu Sel., Kota Palu, Sulawesi Tengah 94111',
                'phone'       => '082274934787',
                'flavors'     => ['Western', 'Pedas', 'Gurih'],
            ],
            [
                'name'        => 'Kaledo Stereo',
                'description' => 'Kedai sup kaledo khas Palu dengan kisaran harga Rp 75.000 – Rp 100.000. Kuah hangat berempah cocok dinikmati saat cuaca dingin.',
                'address'     => '4R8R+JFF, Jl. Diponegoro, Lere, Kec. Palu Bar., Kota Palu, Sulawesi Tengah 94111',
                'phone'       => '081234567890',
                'flavors'     => ['Asia', 'Gurih', 'Hangat'],
            ],
            [
                'name'        => 'Warung Pak Slamet',
                'description' => 'Restoran masakan Indonesia rumahan dengan cita rasa gurih, pedas, dan asin yang khas.',
                'address'     => 'Jl. Sam Ratulangi No.49, Besusu Bar., Kec. Palu Tim., Kota Palu, Sulawesi Tengah 94118',
                'phone'       => '082196929693',
                'flavors'     => ['Asia', 'Gurih', 'Pedas', 'Asin'],
            ],
            [
                'name'        => 'Rumah Makan Padang Gelora',
                'description' => 'Restoran Padang dengan aneka lauk khas Minang seperti rendang, gulai, dan sambal hijau. Pedas dan kaya rempah.',
                'address'     => '4V7C+C9H, Jl. Sam Ratulangi, Besusu Bar., Kec. Palu Tim., Kota Palu, Sulawesi Tengah 94118',
                'phone'       => '085327384947',
                'flavors'     => ['Asia', 'Pedas', 'Gurih'],
            ],
            [
                'name'        => 'RM Tinaku (Khas Kaili)',
                'description' => 'Rumah makan khas Kaili yang menyajikan menu tradisional Sulawesi Tengah dengan bumbu otentik.',
                'address'     => 'Jl. Sungai Sausu, Siranindi, Kec. Palu Bar., Kota Palu, Sulawesi Tengah 94111',
                'phone'       => '082191929478',
                'flavors'     => ['Asia', 'Gurih', 'Pedas'],
            ],
            [
                'name'        => 'Rumah Makan Borobudur',
                'description' => 'Rumah makan dengan menu nusantara lengkap, cocok untuk makan siang bersama keluarga maupun rekan kerja.',
                'address'     => 'Jl. Juanda, Lolu Utara, Kec. Palu Sel., Kota Palu, Sulawesi Tengah 94111',
                'phone'       => '082348919191',
                'flavors'     => ['Asia', 'Gurih', 'Manis'],
            ],
        ];

        foreach ($restaurants as $row) {
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
