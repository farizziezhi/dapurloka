<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRestaurantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'address'     => ['required', 'string'],
            'phone'       => ['nullable', 'string', 'max:30'],
            'image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'flavors'     => ['array'],
            'flavors.*'   => ['integer', 'exists:flavors,id'],
        ];
    }
}
