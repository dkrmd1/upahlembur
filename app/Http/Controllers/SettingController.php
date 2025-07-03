<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first() ?? new Setting(); // fallback default
        return view('setting.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        // Ambil atau buat data setting baru
        $setting = Setting::first() ?? new Setting();

        // Simpan logo jika diupload
        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if ($setting->logo && Storage::exists('public/logo/' . $setting->logo)) {
                Storage::delete('public/logo/' . $setting->logo);
            }

            // Simpan logo baru
            $path = $request->file('logo')->store('public/logo');
            $setting->logo = str_replace('public/logo/', '', $path); // Simpan nama file saja
        }

        $setting->title = $request->input('title') ?? 'LemburManager'; // Default title jika kosong
        $setting->save();

        return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui.');
    }
}
