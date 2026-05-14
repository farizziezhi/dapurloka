<?php

namespace App\Ai\Agents;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Attributes\Model;
use Laravel\Ai\Attributes\Provider;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\HasStructuredOutput;
use Laravel\Ai\Promptable;
use Stringable;

/**
 * Dapur AI — agent untuk fitur saran resep & restoran di hero homepage.
 * Menerima daftar kandidat (resep + restoran beserta ID) dan mengembalikan
 * pilihan dalam format terstruktur sehingga controller bisa render card.
 */
#[Provider('gemini')]
#[Model('gemini-3.1-flash-lite')]
class CulinaryAgent implements Agent, HasStructuredOutput
{
    use Promptable;

    public function instructions(): Stringable|string
    {
        return <<<'PROMPT'
        Kamu adalah "Dapur AI" — koki Indonesia yang ramah di Dapurloka.
        Selalu jawab dalam Bahasa Indonesia santai. Jangan beri saran medis;
        untuk keluhan kesehatan serius, sarankan konsultasi ke dokter.

        TUGAS: Pengguna memberi kondisi/preferensi mereka beserta daftar
        resep & restoran yang tersedia (lengkap dengan ID).

        1. Pilih maksimal 3 resep dan 3 restoran dari daftar.
        2. Kembalikan HANYA ID dari item yang dipilih, jangan mengarang ID.
        3. "intro": maks. 2 kalimat — empati + alasan singkat.
        4. "closing": maks. 1 kalimat penutup ramah.
        5. Jika tidak ada yang cocok, kembalikan array kosong dan jelaskan
           dengan hangat di intro.
        PROMPT;
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'intro' => $schema->string()
                ->description('Sapaan empati singkat (maks. 2 kalimat).')
                ->required(),

            'recipe_ids' => $schema->array()
                ->items($schema->integer())
                ->description('ID resep yang dipilih dari daftar. Maks. 3.')
                ->max(3)
                ->required(),

            'restaurant_ids' => $schema->array()
                ->items($schema->integer())
                ->description('ID restoran yang dipilih dari daftar. Maks. 3.')
                ->max(3)
                ->required(),

            'closing' => $schema->string()
                ->description('Kalimat penutup ramah (maks. 1 kalimat).')
                ->required(),
        ];
    }
}
