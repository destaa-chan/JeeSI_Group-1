<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class TolakLowonganRequest extends FormRequest
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
            // Saat menolak, admin wajib menuliskan alasan (UI-009).
            'catatan_admin' => ['required', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'catatan_admin.required' => 'Alasan penolakan wajib diisi.',
        ];
    }
}
