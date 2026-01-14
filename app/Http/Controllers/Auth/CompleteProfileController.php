<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class CompleteProfileController extends Controller
{
    /**
     * Display the complete profile form.
     */
    public function show(): View
    {
        return view('auth.complete-profile');
    }

    /**
     * Handle the complete profile form submission.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();
        
        $validated = $request->validate([
            'nisn' => ['required', 'string', 'size:10', 'unique:users,nisn,' . $user->id],
            'kelas' => ['required', 'string', 'max:20'],
            'jenis_kelamin' => ['required', 'in:L,P'],
        ], [
            'nisn.required' => 'NISN wajib diisi.',
            'nisn.size' => 'NISN harus terdiri dari 10 digit.',
            'nisn.unique' => 'NISN sudah terdaftar.',
            'kelas.required' => 'Kelas wajib dipilih.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in' => 'Jenis kelamin tidak valid.',
        ]);

        $user->update($validated);

        return redirect()->route('siswa.dashboard')
            ->with('success', 'Profil berhasil dilengkapi!');
    }
}
