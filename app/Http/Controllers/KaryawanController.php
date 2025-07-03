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
        $search = $request->input('search');
        $bulan = $request->input('bulan', now()->format('Y-m'));

        $karyawans = Karyawan::query()
            ->when($search, function ($query) use ($search) {
                $query->where('nama', 'like', "%{$search}%")
                      ->orWhere('nip', 'like', "%{$search}%");
            })
            ->latest()
            ->get();

        return view('karyawan.index', compact('karyawans', 'search', 'bulan'));
    }

    public function store(Request $request)
    {
        $this->authorizeManager();

        $request->validate([
            'nip'                 => 'required|unique:karyawans,nip',
            'nama'                => 'required|string',
            'jabatan'             => 'required|string',
            'group'               => 'nullable|string',
            'gaji_pokok'          => 'required|string',
            'tunjangan'           => 'required|string',
            'bpjs_tk'             => 'nullable|string',
            'bpjs_kes'            => 'nullable|string',
            'bpjs_tk_perusahaan'  => 'nullable|string',
            'bpjs_kes_perusahaan' => 'nullable|string',
            'no_rekening'         => 'nullable|string|max:50',
        ]);

        Karyawan::create($this->parseCurrencyInputs($request));

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil ditambahkan.');
    }

    public function edit(Karyawan $karyawan)
    {
        $this->authorizeManager();
        return view('karyawan.edit', compact('karyawan'));
    }

    public function update(Request $request, Karyawan $karyawan)
    {
        $this->authorizeManager();

        $request->validate([
            'nip'                 => 'required|unique:karyawans,nip,' . $karyawan->id,
            'nama'                => 'required|string',
            'jabatan'             => 'required|string',
            'group'               => 'nullable|string',
            'gaji_pokok'          => 'required|string',
            'tunjangan'           => 'required|string',
            'bpjs_tk'             => 'nullable|string',
            'bpjs_kes'            => 'nullable|string',
            'bpjs_tk_perusahaan'  => 'nullable|string',
            'bpjs_kes_perusahaan' => 'nullable|string',
            'no_rekening'         => 'nullable|string|max:50',
        ]);

        $karyawan->update($this->parseCurrencyInputs($request));

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil diperbarui.');
    }

    public function destroy(Karyawan $karyawan)
    {
        $this->authorizeManager();
        $karyawan->delete();
        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil dihapus.');
    }

    public function export()
    {
        $this->authorizeManager();
        return Excel::download(new KaryawanExport, 'data_karyawan.xlsx');
    }

    public function show(Karyawan $karyawan)
    {
        return response()->json($karyawan);
    }

    private function parseCurrencyInputs(Request $request): array
    {
        return [
            'nip'                 => $request->nip,
            'nama'                => $request->nama,
            'jabatan'             => $request->jabatan,
            'group'               => $request->group,
            'gaji_pokok'          => $this->toInt($request->gaji_pokok),
            'tunjangan'           => $this->toInt($request->tunjangan),
            'bpjs_tk'             => $this->toInt($request->bpjs_tk),
            'bpjs_kes'            => $this->toInt($request->bpjs_kes),
            'bpjs_tk_perusahaan'  => $this->toInt($request->bpjs_tk_perusahaan),
            'bpjs_kes_perusahaan' => $this->toInt($request->bpjs_kes_perusahaan),
            'no_rekening'         => $request->no_rekening, // ⬅️ Tambahkan ke array
        ];
    }

    private function toInt($value): int
    {
        return intval(str_replace('.', '', preg_replace('/[^\d]/', '', $value ?? '0')));
    }

    private function authorizeManager()
    {
        if (auth()->user()->role !== 'manager') {
            abort(403);
        }
    }
}
