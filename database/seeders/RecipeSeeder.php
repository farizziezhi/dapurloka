<?php

namespace Database\Seeders;

use App\Models\Flavor;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'user@dapurloka.test')->first();

        if (! $user) {
            return;
        }

        $flavors = Flavor::pluck('id', 'name');

        $recipes = [
            [
                'title'       => 'Ikan Goreng Tumis Kecombrang',
                'ingredients' => <<<TXT
                4 ekor (1 kg) ikan terisi/kembung como/belanak
                Minyak goreng secukupnya

                Bumbu halus:
                2 siung bawang putih
                1/2 sdt ketumbar
                1/2 cm jahe
                1 sdt garam

                Bumbu tumis:
                3 sdm minyak sayur
                1 buah bunga kecombrang, iris tipis
                3 butir bawang merah, iris tipis
                2 siung bawang putih, iris tipis
                2 buah tomat hijau, iris tipis
                5 buah cabai rawit merah, iris kasar
                1/4 sdt merica bubuk
                1 sdt garam
                TXT,
                'steps' => <<<TXT
                Kerat-kerat kedua sisi badan ikan yang sudah dibersihkan.
                Lumuri ikan dengan bumbu halus hingga rata dan diamkan selama 30 menit.
                Goreng ikan dalam minyak panas dan banyak hingga kering dan matang. Angkat dan tiriskan.

                Bumbu tumis:
                Panaskan minyak, tumis bumbu halus hingga layu dan wangi.
                Masukkan irisan kecombrang, tomat hijau dan cabai rawit, aduk hingga layu.
                Tambahkan merica dan garam, aduk sebentar hingga rata lalu angkat.
                Taruh ikan goreng di piring saji. Tuangi kecombrang tumis dan sajikan segera.
                TXT,
                'flavors' => ['Asia', 'Pedas', 'Gurih'],
            ],
            [
                'title'       => 'Soto Kuning Ayam',
                'ingredients' => <<<TXT
                1/2 ekor ayam negeri, potong dua
                1 liter air
                2 sdm minyak sayur
                1 batang serai, memarkan
                2 lembar daun salam
                2 lembar daun jeruk

                Bumbu halus:
                4 butir kemiri
                3 cm kunyit
                1 cm jahe
                5 butir bawang putih
                3 siung bawang merah
                1/2 sdt merica butiran
                2 sdt garam

                Pelengkap:
                Tauge
                Suun
                Telur rebus
                Daun bawang
                Bawang merah goreng
                Jeruk nipis
                TXT,
                'steps' => <<<TXT
                Didihkan air, rebus ayam dengan api kecil hingga hampir lunak.
                Tumis bumbu halus bersama daun jeruk, daun salam, dan serai hingga wangi. Angkat.
                Masukkan tumisan ke dalam rebusan ayam.
                Rebus dengan api kecil hingga daging ayam lunak. Angkat ayam, tiriskan, lalu suwir kasar.
                Susun ayam, suun, dan tauge dalam mangkuk saji.
                Tuangi kaldu panas dan sajikan dengan daun bawang, bawang goreng, dan jeruk nipis.
                TXT,
                'flavors' => ['Asia', 'Gurih', 'Hangat'],
            ],
            [
                'title'       => 'Kaledo (Kaki Lembu Donggala)',
                'ingredients' => <<<TXT
                1 kg kaki sapi/tetelan sapi, potong-potong
                2 buah asam mangga muda (alternatif: belimbing wuluh atau asam jawa)
                5 siung bawang merah, haluskan
                3 siung bawang putih, haluskan
                15 buah cabai rawit, rebus lalu haluskan untuk sambal
                Garam dan penyedap rasa secukupnya
                Air secukupnya untuk merebus
                TXT,
                'steps' => <<<TXT
                Rebus potongan kaki atau tulang sapi hingga kaldunya keluar dan teksturnya empuk. Gunakan panci presto agar lebih cepat.
                Tumis bawang merah dan bawang putih halus hingga harum.
                Masukkan tumisan bumbu ke dalam rebusan daging.
                Tambahkan asam mangga muda dan garam. Masak hingga bumbu meresap sempurna.
                Sajikan panas dengan taburan bawang goreng dan sambal cabai rawit terpisah.
                TXT,
                'flavors' => ['Asia', 'Gurih', 'Hangat', 'Asam'],
            ],
            [
                'title'       => 'Ikan Palumara Khas Palu',
                'ingredients' => <<<TXT
                4 ekor ikan katombo, potong dua bagian (boleh diganti bandeng, gurame, atau ikan lain)
                3 sdm minyak goreng untuk menumis (lebih wangi pakai minyak kelapa kampung)
                1 1/2 sdt garam
                1 sdt gula pasir
                1 buah tomat, potong 4 bagian
                9 mata asam jawa, rendam dengan 50 ml air panas
                2 siung bawang merah
                2 butir bawang putih
                3 cm kunyit (atau 1 sdm kunyit bubuk)
                2 buah cabai keriting
                10 buah cabai rawit (sesuai selera)
                TXT,
                'steps' => <<<TXT
                Haluskan kunyit, lalu lumuri ikan. Sisihkan.
                Haluskan bawang merah, bawang putih, cabai keriting, dan cabai rawit, kemudian tumis hingga harum.
                Masukkan asam jawa, ikan, garam, gula, tomat, dan air. Aduk pelan hingga rata.
                Biarkan mendidih 10-15 menit hingga kuah mengental. Hidangkan.
                TXT,
                'flavors' => ['Asia', 'Pedas', 'Asam', 'Gurih'],
            ],
            [
                'title'       => 'Ramen Jepang',
                'ingredients' => <<<TXT
                1 bungkus mi instan rasa kari ayam
                1 buah sosis
                1 butir telur
                2 lembar nori, potong-potong
                2 buah cabai rawit (sesuai selera)
                2 sdm jagung rebus
                300 ml air
                TXT,
                'steps' => <<<TXT
                Panaskan 150 ml air, masukkan mi instan selama 2-3 menit lalu tiriskan.
                Didihkan 150 ml air, tambahkan kocokan telur dan sosis.
                Tuang mi ke mangkuk, aduk bersama bumbu mi instan, lalu siram dengan kuah berisi telur dan sosis.
                Letakkan jagung rebus, potongan cabai, dan nori di atas mi.
                Hidangkan selagi hangat.
                TXT,
                'flavors' => ['Asia', 'Gurih', 'Hangat'],
            ],
            [
                'title'       => 'Kebab Turki',
                'ingredients' => <<<TXT
                Bahan isian:
                200 gram daging ayam cincang
                3 daun selada, cincang
                2 bawang putih, cincang
                1 bawang bombay, iris tipis
                1 sdt garam
                1 sdt lada
                1 ruas jahe, geprek
                1/2 sdt ketumbar bubuk
                1/4 sdt jintan
                1 sdm mentega
                Timun, potong kecil
                Mayones secukupnya
                Yogurt plain secukupnya
                Saus sambal atau saus tomat
                2 cabai besar, potong menyamping

                Bahan kulit:
                2 kulit tortilla instan, potong jadi 2 bagian
                Mentega secukupnya
                TXT,
                'steps' => <<<TXT
                Buat isian. Panaskan teflon dengan mentega lalu tumis bawang putih, bawang bombay, dan jahe sampai wangi.
                Tambahkan daging ayam cincang, garam, lada, jintan, dan ketumbar.
                Untuk versi pedas, masukkan cabai dan saus sambal/tomat sesuai selera. Tumis sampai harum.
                Panggang kedua sisi tortilla hingga setengah matang lalu angkat.
                Susun di atas tortilla: tumisan ayam, selada, timun, mayones, yogurt, dan saus. Gulung.
                Panggang kembali di teflon hingga tortilla mengering. Sajikan hangat.
                TXT,
                'flavors' => ['Western', 'Gurih', 'Pedas'],
            ],
            [
                'title'       => 'Chicken Cordon Bleu',
                'ingredients' => <<<TXT
                300 gram dada ayam fillet
                2 lembar smoked beef
                2 lembar keju slice
                Keju mozzarella secukupnya

                Bumbu marinasi:
                Oregano dan parsley kering
                Garam dan lada secukupnya

                Bumbu pelapis:
                Oregano dan parsley kering
                5 sdm tepung bumbu
                Tepung panir secukupnya
                Air secukupnya
                Saus sambal atau saus tomat
                TXT,
                'steps' => <<<TXT
                Pipihkan dada ayam fillet, lalu taburkan garam, lada, parsley, dan oregano pada kedua sisi.
                Susun smoked beef dan keju slice di atas ayam, gulung, lalu padatkan.
                Sematkan tusuk gigi supaya gulungan tidak terbuka.
                Lumuri dengan bumbu pelapis lalu celupkan ke tepung panir.
                Masukkan ke kulkas sekitar 20 menit.
                Goreng dengan api kecil hingga kedua sisi matang merata. Angkat.
                Sajikan dengan saus sambal atau saus tomat.
                TXT,
                'flavors' => ['Western', 'Gurih', 'Asin'],
            ],
            [
                'title'       => 'Rosemary Chicken ala Italia',
                'ingredients' => <<<TXT
                Daging ayam fillet bagian dada atau paha
                Biji jagung
                Potongan wortel kecil sepanjang 4 cm
                Garam, merica, dan lada butir secukupnya
                Rosemary dan thyme secukupnya
                Mentega secukupnya
                Sejumput garam
                TXT,
                'steps' => <<<TXT
                Taburi ayam fillet dengan garam, lada butir, thyme, dan rosemary.
                Panaskan teflon dengan mentega, panggang ayam fillet hingga matang merata.
                Tumis jagung dan wortel, tambah sedikit air dan sejumput garam, masak hingga matang.
                Sajikan rosemary chicken dengan tumisan jagung dan wortel di pinggirnya.
                Nikmati selagi hangat.
                TXT,
                'flavors' => ['Western', 'Gurih'],
            ],
            [
                'title'       => 'Wedang Telang Madu',
                'ingredients' => <<<TXT
                8 kuntum bunga telang kering
                250 ml air
                2 sdm madu
                TXT,
                'steps' => <<<TXT
                Siapkan bahan.
                Rebus air hingga mendidih.
                Tuang madu ke dalam gelas, masukkan bunga telang dan air mendidih.
                Tunggu hingga air berubah warna menjadi biru. Siap disajikan.
                TXT,
                'flavors' => ['Asia', 'Manis', 'Hangat'],
            ],
            [
                'title'       => 'Es Pisang Ijo',
                'ingredients' => <<<TXT
                Bahan utama:
                8-10 buah pisang raja atau pisang kepok matang dan manis

                Bahan kulit hijau:
                100 gram tepung terigu
                100 gram tepung beras
                50 gram tepung tapioka (sagu)
                65 ml santan instan
                500 ml air (campuran air biasa dan air perasan daun pandan)
                50 gram gula pasir
                1/2 sdt garam
                Pasta pandan secukupnya

                Bahan bubur sumsum:
                70 gram tepung beras
                700 ml santan cair
                1/2 sdt garam
                2 lembar daun pandan

                Pelengkap:
                Es serut atau es batu secukupnya
                Sirup pisang Ambon (atau sirup cocopandan)
                Susu kental manis putih
                TXT,
                'steps' => <<<TXT
                Membuat pisang ijo:
                Kukus pisang utuh beserta kulitnya selama 15 menit hingga matang dan manisnya keluar. Angkat, dinginkan, lalu kupas.
                Campur semua bahan kulit hijau di wadah. Aduk dengan whisk hingga rata dan tidak bergerindil.
                Masak adonan di teflon dengan api kecil sambil terus diaduk hingga menggumpal, kalis, dan tidak lengket. Matikan api.
                Ambil adonan kulit secukupnya, pipihkan, letakkan pisang di tengah, lalu bungkus rapi menyerupai pisang.
                Kukus kembali pisang berbalut adonan selama 15 menit. Angkat dan dinginkan.

                Membuat bubur sumsum:
                Campur tepung beras, santan cair, garam, dan daun pandan dalam panci.
                Masak dengan api sedang cenderung kecil sambil diaduk perlahan hingga mengental dan meletup-letup. Matikan api dan biarkan dingin.

                Penyajian:
                Potong pisang ijo dingin sesuai selera (lapisi pisau dengan plastik agar tidak lengket).
                Siapkan mangkuk saji. Beri es batu atau es serut di bagian bawah. Tambahkan bubur sumsum dan potongan pisang ijo.
                Siram dengan sirup dan susu kental manis sesuai selera.
                TXT,
                'flavors' => ['Asia', 'Manis'],
            ],
            [
                'title'       => 'Sarabba',
                'ingredients' => <<<TXT
                350 ml air
                60 gram jahe bakar, geprek
                60 gram gula aren
                2 butir cengkeh
                1/2 sdt kayu manis bubuk
                1/4 sdt garam
                150 ml santan kental
                TXT,
                'steps' => <<<TXT
                Masukkan semua bahan kecuali santan ke dalam panci.
                Masak dengan api kecil hingga gula larut.
                Tambahkan santan, aduk hingga mendidih dan tercampur, lalu matikan api.
                Sajikan di gelas untuk dua orang.
                TXT,
                'flavors' => ['Asia', 'Manis', 'Hangat', 'Pedas'],
            ],
        ];

        foreach ($recipes as $row) {
            $recipe = Recipe::updateOrCreate(
                ['title' => $row['title']],
                [
                    'user_id'     => $user->id,
                    'ingredients' => $this->dedent($row['ingredients']),
                    'steps'       => $this->dedent($row['steps']),
                    'status'      => 'approved',
                ]
            );

            $recipe->flavors()->sync(
                collect($row['flavors'])->map(fn ($name) => $flavors[$name])->all()
            );
        }
    }

    /** Strip common leading indentation from heredoc blocks. */
    private function dedent(string $text): string
    {
        $lines = explode("\n", $text);
        $min = PHP_INT_MAX;

        foreach ($lines as $line) {
            if (trim($line) === '') {
                continue;
            }
            $indent = strlen($line) - strlen(ltrim($line, ' '));
            if ($indent < $min) {
                $min = $indent;
            }
        }

        if ($min === PHP_INT_MAX || $min === 0) {
            return trim($text);
        }

        return trim(implode("\n", array_map(
            fn ($line) => substr($line, $min) ?: $line,
            $lines
        )));
    }
}
