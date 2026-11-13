<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Http\Requests\Alumni\UpdateProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        return view('alumni.profile', ['alumni' => request()->user()->alumni]);
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $request->user()->alumni()->updateOrCreate(
            ['id_user' => $request->user()->id_user],
            [...$request->validated(), 'updated_at' => now()]
        );

        return redirect()->route('alumni.profile.edit')->with('success', 'Profil berhasil disimpan.');
    }
}
