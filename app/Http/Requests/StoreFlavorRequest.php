<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFlavorRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Authorization handled at controller via Gate::authorize('admin').
        return true;
    }

    public function rules(): array
    {
        $flavorId = $this->route('flavor')?->id;

        return [
            'name'        => ['required', 'string', 'max:50', Rule::unique('flavors', 'name')->ignore($flavorId)],
            'description' => ['nullable', 'string', 'max:255'],
        ];
    }
}
