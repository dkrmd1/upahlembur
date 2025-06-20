<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lembur;
use App\Models\Karyawan;
use Carbon\Carbon;

class LemburBaruController extends Controller
{
    public function index()
    {
        $lemburs = Lembur::with('karyawan')->latest()->get();
        $karyawans = Karyawan::all();
        $totalJam = $lemburs->sum('jam');
        $totalUpah = $lemburs->sum('upah');

        return view('lembur.index', compact('lemburs', 'karyawans', 'totalJam', 'totalUpah'));
    }

    public function create()
    {
        $karyawans = Karyawan::all();
        return view('lembur.create', compact('karyawans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:karyawans,id',
            'tanggal'     => 'required|date',
            'jam'         => 'required|integer|min:1',
        ]);

        $karyawan = Karyawan::findOrFail($request->karyawan_id);
        $tanggal = Carbon::parse($request->tanggal);
        $hari = $tanggal->format('l');
        $jam = $request->jam;

        $gajiPerJam = $karyawan->gaji_pokok / 173;
        $isLibur = in_array($hari, ['Saturday', 'Sunday']);
        $upah = 0;

        if ($isLibur) {
            if ($jam > 5) {
                return back()->withErrors(['jam' => 'Hari libur maksimal 5 jam lembur.']);
            }
            $upah = $jam * 2 * $gajiPerJam;
        } else {
            if ($jam > 3) {
                return back()->withErrors(['jam' => 'Hari biasa maksimal 3 jam lembur.']);
            }
            if ($jam == 1) {
                $upah = 1 * 1.5 * $gajiPerJam;
            } else {
                $upah = (1 * 1.5 * $gajiPerJam) + (($jam - 1) * 2 * $gajiPerJam);
            }
        }

        Lembur::create([
            'karyawan_id' => $request->karyawan_id,
            'tanggal'     => $request->tanggal,
            'jam'         => $jam,
            'upah'        => round($upah),
        ]);

        return redirect()->route('lembur.index')->with('success', 'Data lembur berhasil ditambahkan.');
    }

    public function edit(Lembur $lembur)
    {
        $karyawans = Karyawan::all();
        return view('lembur.edit', compact('lembur', 'karyawans'));
    }

    public function update(Request $request, Lembur $lembur)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:karyawans,id',
            'tanggal'     => 'required|date',
            'jam'         => 'required|integer|min:1',
        ]);

        $karyawan = Karyawan::findOrFail($request->karyawan_id);
        $tanggal = Carbon::parse($request->tanggal);
        $hari = $tanggal->format('l');
        $jam = $request->jam;

        $gajiPerJam = $karyawan->gaji_pokok / 173;
        $isLibur = in_array($hari, ['Saturday', 'Sunday']);
        $upah = 0;

        if ($isLibur) {
            if ($jam > 5) {
                return back()->withErrors(['jam' => 'Hari libur maksimal 5 jam lembur.']);
            }
            $upah = $jam * 2 * $gajiPerJam;
        } else {
            if ($jam > 3) {
                return back()->withErrors(['jam' => 'Hari biasa maksimal 3 jam lembur.']);
            }
            if ($jam == 1) {
                $upah = 1 * 1.5 * $gajiPerJam;
            } else {
                $upah = (1 * 1.5 * $gajiPerJam) + (($jam - 1) * 2 * $gajiPerJam);
            }
        }

        $lembur->update([
            'karyawan_id' => $request->karyawan_id,
            'tanggal'     => $request->tanggal,
            'jam'         => $jam,
            'upah'        => round($upah),
        ]);

        return redirect()->route('lembur.index')->with('success', 'Data lembur berhasil diperbarui.');
    }

    public function destroy(Lembur $lembur)
    {
        $lembur->delete();
        return redirect()->route('lembur.index')->with('success', 'Data lembur berhasil dihapus.');
    }
}
