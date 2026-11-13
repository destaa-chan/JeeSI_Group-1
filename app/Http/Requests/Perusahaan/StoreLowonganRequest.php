<?php

namespace App\Http\Requests\Perusahaan;

use Illuminate\Foundation\Http\FormRequest;

class StoreLowonganRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'perusahaan';
    }

    public function rules(): array
    {
        return [
            'posisi' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'kriteria_kandidat' => ['required', 'string'],
        ];
    }
}
