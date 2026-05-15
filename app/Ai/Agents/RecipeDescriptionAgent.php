<?php

namespace App\Ai\Agents;

use Laravel\Ai\Attributes\Model;
use Laravel\Ai\Attributes\Provider;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Promptable;
use Stringable;

/**
 * Agent untuk generate deskripsi singkat resep yang menggugah selera.
 * Dipanggil di halaman detail resep.
 */
#[Provider('gemini')]
#[Model('gemini-3.1-flash-lite')]
class RecipeDescriptionAgent implements Agent
{
    use Promptable;

    public function instructions(): Stringable|string
    {
        return <<<'PROMPT'
        Kamu adalah koki Indonesia yang jago menulis deskripsi makanan.
        Tulis deskripsi resep dalam 2-3 kalimat Bahasa Indonesia yang:
        - Menggugah selera dan membuat pembaca ingin mencoba
        - Menyebutkan karakter rasa atau tekstur utama
        - Santai dan hangat, tidak kaku
        Jangan pakai markdown, cukup teks biasa.
        PROMPT;
    }
}
