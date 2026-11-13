<?php

namespace App\Http\Requests\Perusahaan;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLamaranStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'perusahaan';
    }

    public function rules(): array
    {
        return [
            'status_lamaran' => [
                'required',
                Rule::in(['dilihat', 'diundang', 'diterima', 'ditolak']),
            ],
        ];
    }
}
