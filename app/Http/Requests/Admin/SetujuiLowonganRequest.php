<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SetujuiLowonganRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Hak akses sudah dijaga middleware role:admin pada route.
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Saat menyetujui, catatan bersifat opsional.
            'catatan_admin' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
