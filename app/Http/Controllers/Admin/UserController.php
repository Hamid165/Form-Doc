<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Helper to restrict access to Admin only.
     */
    private function checkAdmin()
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Halaman ini hanya dapat diakses oleh Admin Sistem.');
        }
    }

    /**
     * Export printable PDF of officers list.
     */
    public function exportPdf()
    {
        $this->checkAdmin();
        $users = User::orderBy('name', 'asc')->get();
        return view('admin.users.pdf', compact('users'));
    }

    /**
     * Display a listing of all users/officers.
     */
    public function index(Request $request)
    {
        $this->checkAdmin();

        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('nip_kwt', 'like', "%{$search}%")
                  ->orWhere('unit_kerja', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->orderBy('name', 'asc')->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Store a newly created officer/user in storage.
     */
    public function store(Request $request)
    {
        $this->checkAdmin();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:petugas,pimpinan,admin',
            'password' => 'required|string|min:4',
            'nip_kwt' => 'nullable|string|max:100',
            'unit_kerja' => 'nullable|string|max:255',
        ]);

        $user = User::create($validated);

        \App\Models\ActivityLog::log('Tambah Petugas', "Menambah petugas baru: {$user->name} (" . strtoupper($user->role) . ")");

        // Also add to MasterSigner if role is pimpinan
        if ($user->role === 'pimpinan') {
            \App\Models\FormCctv\MasterSigner::firstOrCreate(
                ['nama' => $user->name],
                [
                    'nipp' => $user->nip_kwt ?? 'P.' . rand(100000, 999999),
                    'jabatan' => $user->unit_kerja ?? 'Pimpinan',
                ]
            );
        }

        return redirect()->route('users.index')
            ->with('success', "Petugas/Pengguna baru '{$validated['name']}' berhasil ditambahkan.");
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, $id)
    {
        $this->checkAdmin();

        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'role' => 'required|in:petugas,pimpinan,admin',
            'password' => 'nullable|string|min:4',
            'nip_kwt' => 'nullable|string|max:100',
            'unit_kerja' => 'nullable|string|max:255',
        ]);

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $user->update($validated);

        \App\Models\ActivityLog::log('Edit Pengguna', "Memperbarui data pengguna: {$user->name}");

        return redirect()->route('users.index')
            ->with('success', "Data pengguna '{$user->name}' berhasil diperbarui.");
    }

    /**
     * Reset password for the specified user.
     */
    public function resetPassword(Request $request, $id)
    {
        $this->checkAdmin();

        $user = User::findOrFail($id);

        $request->validate([
            'new_password' => 'required|string|min:4',
        ]);

        $user->password = $request->new_password;
        $user->save();

        \App\Models\ActivityLog::log('Reset Password', "Memperbarui/reset password pengguna: {$user->name}");

        return redirect()->route('users.index')
            ->with('success', "Password untuk pengguna '{$user->name}' berhasil diperbarui.");
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy($id)
    {
        $this->checkAdmin();

        $user = User::findOrFail($id);

        if (auth()->id() === $user->id) {
            return redirect()->route('users.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif digunakan.');
        }

        $userName = $user->name;
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', "Pengguna '{$userName}' berhasil dihapus.");
    }
}
