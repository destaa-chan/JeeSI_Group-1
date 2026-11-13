<?php

namespace App\Http\Requests\Alumni;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'alumni';
    }

    public function rules(): array
    {
        $alumniId = $this->user()?->alumni?->id_alumni;

        return [
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'nim' => ['required', 'string', 'max:255', Rule::unique('alumni', 'nim')->ignore($alumniId, 'id_alumni')],
            'program_studi' => ['required', 'string', 'max:255'],
            'pendidikan' => ['required', 'string', 'max:255'],
            'kompetensi' => ['required', 'string'],
            'minat_studi' => ['required', 'string'],
        ];
    }
}
