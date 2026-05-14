<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRecipeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'       => ['required', 'string', 'max:255'],
            'ingredients' => ['required', 'string'],
            'steps'       => ['required', 'string'],
            'image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'flavors'     => ['array'],
            'flavors.*'   => ['integer', 'exists:flavors,id'],
        ];
    }
}
