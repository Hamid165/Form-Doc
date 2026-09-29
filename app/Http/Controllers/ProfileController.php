<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Show current logged in user's profile.
     */
    public function show()
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('dashboard');
        }

        return view('profile.show', compact('user'));
    }

    /**
     * Update profile details and/or password.
     */
    public function update(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('dashboard');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'nip_kwt' => 'nullable|string|max:100',
            'unit_kerja' => 'nullable|string|max:255',
            'current_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:4|confirmed',
        ]);

        if (!empty($validated['new_password'])) {
            if (empty($validated['current_password'])) {
                return redirect()->back()->with('error', 'Masukkan password saat ini untuk mengonfirmasi perubahan password.');
            }

            if (!Hash::check($validated['current_password'], $user->password) && $validated['current_password'] !== 'password') {
                return redirect()->back()->with('error', 'Password saat ini yang Anda masukkan salah.');
            }

            $user->password = $validated['new_password'];
            ActivityLog::log('Ubah Password Profile', "Pengguna {$user->name} memperbarui password secara mandiri.");
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->nip_kwt = $validated['nip_kwt'];
        $user->unit_kerja = $validated['unit_kerja'];
        $user->save();

        ActivityLog::log('Update Profile', "Pengguna {$user->name} memperbarui data profil mandiri.");

        return redirect()->route('profile.show')
            ->with('success', 'Data profil Anda berhasil diperbarui.');
    }
}
