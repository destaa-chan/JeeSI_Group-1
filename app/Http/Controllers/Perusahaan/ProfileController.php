<?php

namespace App\Http\Controllers\Perusahaan;

use App\Http\Controllers\Controller;
use App\Http\Requests\Perusahaan\UpdateProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        return view('perusahaan.profile', ['perusahaan' => request()->user()->perusahaan]);
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $request->user()->perusahaan()->updateOrCreate(
            ['id_user' => $request->user()->id_user],
            [...$request->validated(), 'created_at' => $request->user()->perusahaan?->created_at ?? now(), 'updated_at' => now()]
        );

        return redirect()->route('perusahaan.profile.edit')->with('success', 'Profil perusahaan berhasil disimpan.');
    }
}
