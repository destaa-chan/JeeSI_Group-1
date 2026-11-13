<?php

namespace App\Http\Requests\Alumni;

use Illuminate\Foundation\Http\FormRequest;

class StorePortofolioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'alumni';
    }

    public function rules(): array
    {
        return [
            'nama_portofolio' => ['required', 'string', 'max:255'],
            'deskripsi' => ['required', 'string'],
            'file_portofolio' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
        ];
    }
}
