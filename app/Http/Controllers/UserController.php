<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Tampilkan daftar semua pengguna
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('users.index', compact('users'));
    }

    /**
     * Simpan pengguna baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ], [
            'name.required'      => 'Nama pengguna wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email sudah digunakan oleh pengguna lain.',
            'password.required'  => 'Password wajib diisi.',
            'password.min'       => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->back()->with('success', 'Pengguna baru berhasil ditambahkan!');
    }

    /**
     * Update data pengguna
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $rules = [
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
        ];

        // Validasi password hanya jika diisi
        if ($request->filled('password')) {
            $rules['password'] = 'min:6|confirmed';
        }

        $validated = $request->validate($rules, [
            'name.required'      => 'Nama pengguna wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email sudah digunakan oleh pengguna lain.',
            'password.min'       => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $updateData = [
            'name'  => $validated['name'],
            'email' => $validated['email'],
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        return redirect()->back()->with('success', 'Data pengguna berhasil diperbarui!');
    }

    /**
     * Hapus pengguna
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Cegah hapus diri sendiri
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->back()->with('success', 'Pengguna berhasil dihapus.');
    }
}
