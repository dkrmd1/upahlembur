<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use App\Exports\KaryawanExport;
use Maatwebsite\Excel\Facades\Excel;

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

        return view('karyawan.index', compact('karyawans', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip'        => 'required|unique:karyawans,nip',
            'nama'       => 'required|string',
            'jabatan'    => 'required|string',
            'gaji_pokok' => 'required|string',
            'tunjangan'  => 'required|string',
        ]);

        // Hapus titik dan non-digit dari input rupiah
        $gajiPokok = intval(str_replace('.', '', preg_replace('/[^\d]/', '', $request->gaji_pokok)));
        $tunjangan = intval(str_replace('.', '', preg_replace('/[^\d]/', '', $request->tunjangan)));

        Karyawan::create([
            'nip'        => $request->nip,
            'nama'       => $request->nama,
            'jabatan'    => $request->jabatan,
            'gaji_pokok' => $gajiPokok,
            'tunjangan'  => $tunjangan,
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
            'gaji_pokok' => 'required|string',
            'tunjangan'  => 'required|string',
        ]);

        $gajiPokok = intval(str_replace('.', '', preg_replace('/[^\d]/', '', $request->gaji_pokok)));
        $tunjangan = intval(str_replace('.', '', preg_replace('/[^\d]/', '', $request->tunjangan)));

        $karyawan->update([
            'nip'        => $request->nip,
            'nama'       => $request->nama,
            'jabatan'    => $request->jabatan,
            'gaji_pokok' => $gajiPokok,
            'tunjangan'  => $tunjangan,
        ]);

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil diperbarui.');
    }

    public function destroy(Karyawan $karyawan)
    {
        $karyawan->delete();
        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil dihapus.');
    }

    public function export()
    {
        return Excel::download(new KaryawanExport, 'data_karyawan.xlsx');
    }
}
