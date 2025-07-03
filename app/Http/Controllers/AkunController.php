<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AkunController extends Controller
{
    /**
     * Tampilkan halaman pengaturan akun.
     */
    public function setting()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        return view('akun.setting', [
            'user' => $user
        ]);
    }

    /**
     * Update data akun atau password.
     */
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        $formType = $request->input('form'); // 'edit' atau 'password'

        // ====== FORM EDIT PROFIL ======
        if ($formType === 'edit') {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            try {
                $user->name = $request->name;
                $user->email = $request->email;

                // Jika ada upload avatar
                if ($request->hasFile('avatar')) {
                    // Hapus avatar lama
                    if ($user->avatar && Storage::exists('public/avatars/' . $user->avatar)) {
                        Storage::delete('public/avatars/' . $user->avatar);
                    }

                    $file = $request->file('avatar');
                    $filename = time() . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('public/avatars', $filename);
                    $user->avatar = $filename;
                }

                $user->save();

                return redirect()->route('akun.setting')->with('success', 'Profil berhasil diperbarui.');
            } catch (\Throwable $e) {
                return back()->withErrors([
                    'error' => 'Gagal memperbarui profil: ' . $e->getMessage()
                ]);
            }
        }

        // ====== FORM GANTI PASSWORD ======
        elseif ($formType === 'password') {
            $request->validate([
                'password' => 'required|string|min:6|confirmed',
            ]);

            try {
                $user->password = Hash::make($request->password);
                $user->save();

                return redirect()->route('akun.setting')->with('success', 'Password berhasil diperbarui.');
            } catch (\Throwable $e) {
                return back()->withErrors([
                    'error' => 'Gagal mengganti password: ' . $e->getMessage()
                ]);
            }
        }

        // ====== FORM TIDAK DIKENALI ======
        return back()->withErrors(['error' => 'Form tidak dikenali.']);
    }
}
