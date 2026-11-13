<?php

namespace App\Http\Requests\Alumni;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLamaranRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'alumni';
    }

    public function rules(): array
    {
        return [
            'id_portofolio' => [
                'nullable',
                Rule::exists('portofolio', 'id_portofolio')->where(
                    fn ($query) => $query->where('id_alumni', $this->user()?->alumni?->id_alumni)
                ),
            ],
            'cover_letter' => ['required', 'string'],
        ];
    }
}
