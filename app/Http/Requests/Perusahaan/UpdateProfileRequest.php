<?php

namespace App\Http\Requests\Perusahaan;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'perusahaan';
    }

    public function rules(): array
    {
        return [
            'nama_perusahaan' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string'],
            'deskripsi' => ['required', 'string'],
        ];
    }
}
