<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Menampilkan daftar user, dengan fitur pencarian.
     */
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('nip', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->latest()->get();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Simpan user baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'nip'      => 'required|string|max:100|unique:users,nip',
            'password' => 'required|min:6',
            'role'     => 'required|in:admin,manager',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'nip'      => $request->nip,
            'role'     => $request->role,
            'password' => $request->password, // sudah otomatis hash via mutator
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Update user yang ada.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'nip'      => 'required|string|max:100|unique:users,nip,' . $user->id,
            'role'     => 'required|in:admin,manager',
            'password' => 'nullable|min:6',
        ]);

        $user->name  = $request->name;
        $user->email = $request->email;
        $user->nip   = $request->nip;
        $user->role  = $request->role;

        if ($request->filled('password')) {
            $user->password = $request->password; // otomatis hash
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    /**
     * Hapus user.
     */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}
