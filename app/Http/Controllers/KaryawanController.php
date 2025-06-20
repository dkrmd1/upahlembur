<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {
        // Ambil query pencarian jika ada
        $search = $request->input('search');

        $karyawans = Karyawan::query()
            ->when($search, function ($query) use ($search) {
                $query->where('nama', 'like', "%{$search}%")
                      ->orWhere('nip', 'like', "%{$search}%");
            })
            ->latest()
            ->get();

        return view('karyawan.index', compact('karyawans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip'        => 'required|unique:karyawans,nip',
            'nama'       => 'required|string',
            'jabatan'    => 'required|string',
            'gaji_pokok' => 'required|integer|min:0',
            'tunjangan'  => 'required|integer|min:0',
        ]);

        Karyawan::create([
            'nip'        => $request->nip,
            'nama'       => $request->nama,
            'jabatan'    => $request->jabatan,
            'gaji_pokok' => $request->gaji_pokok,
            'tunjangan'  => $request->tunjangan,
        ]);

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil ditambahkan.');
    }

    public function edit(Karyawan $karyawan)
    {
        return response()->json($karyawan);
    }

    public function update(Request $request, Karyawan $karyawan)
    {
        $request->validate([
            'nip'        => 'required|unique:karyawans,nip,' . $karyawan->id,
            'nama'       => 'required|string',
            'jabatan'    => 'required|string',
            'gaji_pokok' => 'required|integer|min:0',
            'tunjangan'  => 'required|integer|min:0',
        ]);

        $karyawan->update([
            'nip'        => $request->nip,
            'nama'       => $request->nama,
            'jabatan'    => $request->jabatan,
            'gaji_pokok' => $request->gaji_pokok,
            'tunjangan'  => $request->tunjangan,
        ]);

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil diperbarui.');
    }

    public function destroy(Karyawan $karyawan)
    {
        $karyawan->delete();
        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil dihapus.');
    }
}
