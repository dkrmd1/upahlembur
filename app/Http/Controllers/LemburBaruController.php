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
        $lemburs = Lembur::with('karyawan')->orderBy('tanggal', 'desc')->get();
        $karyawans = Karyawan::all();
        $totalJam = $lemburs->sum('jam');
        $totalUpah = $lemburs->sum('upah');

        return view('lembur.index', compact('lemburs', 'karyawans', 'totalJam', 'totalUpah'));
    }

    public function store(Request $request)
    {
        $this->authorizeManager();

        $validated = $request->validate([
            'karyawan_id' => 'required|exists:karyawans,id',
            'tanggal'     => 'required|date',
            'jam'         => 'required|numeric|min:1',
        ]);

        try {
            $karyawan = Karyawan::findOrFail($validated['karyawan_id']);
            $tanggal = Carbon::parse($validated['tanggal']);
            $jam = (int) $validated['jam'];
            $upah = $this->hitungUpah($karyawan, $tanggal, $jam);

            Lembur::create([
                'karyawan_id' => $karyawan->id,
                'tanggal'     => $tanggal->toDateString(),
                'jam'         => $jam,
                'upah'        => round($upah),
            ]);

            return redirect()->route('lembur.index')->with('success', 'Data lembur berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menambah data: ' . $e->getMessage())->withInput();
        }
    }

    public function update(Request $request, Lembur $lembur)
    {
        $this->authorizeManager();

        $validated = $request->validate([
            'karyawan_id' => 'required|exists:karyawans,id',
            'tanggal'     => 'required|date',
            'jam'         => 'required|numeric|min:1',
        ]);

        try {
            $karyawan = Karyawan::findOrFail($validated['karyawan_id']);
            $tanggal = Carbon::parse($validated['tanggal']);
            $jam = (int) $validated['jam'];
            $upah = $this->hitungUpah($karyawan, $tanggal, $jam);

            $lembur->update([
                'karyawan_id' => $karyawan->id,
                'tanggal'     => $tanggal->toDateString(),
                'jam'         => $jam,
                'upah'        => round($upah),
            ]);

            return redirect()->route('lembur.index')->with('success', 'Data lembur berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengupdate data: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Lembur $lembur)
    {
        $this->authorizeManager();
        $lembur->delete();

        return redirect()->route('lembur.index')->with('success', 'Data lembur berhasil dihapus.');
    }

    public function create()
    {
        $this->authorizeManager();
        $karyawans = Karyawan::all();
        return view('lembur.create', compact('karyawans'));
    }

    public function show($id)
    {
        abort(404, 'Halaman tidak tersedia.');
    }

    /**
     * Hitung upah lembur berdasarkan hari dan jumlah jam
     */
    private function hitungUpah(Karyawan $karyawan, Carbon $tanggal, int $jam): float
    {
        $gajiPerJam = $karyawan->gaji_pokok / 173;
        $hari = $tanggal->format('l'); // Sunday, Monday, etc.
        $isLibur = in_array($hari, ['Saturday', 'Sunday']);

        if ($isLibur) {
            if ($jam > 5) {
                throw new \Exception("Hari libur maksimal 5 jam lembur.");
            }
            return $jam * 2 * $gajiPerJam;
        }

        if ($jam > 3) {
            throw new \Exception("Hari kerja maksimal 3 jam lembur.");
        }

        // Formula: jam pertama 1.5x, sisanya 2x
        return ($jam == 1)
            ? 1 * 1.5 * $gajiPerJam
            : (1 * 1.5 * $gajiPerJam) + (($jam - 1) * 2 * $gajiPerJam);
    }

    /**
     * Validasi role: hanya manager yang boleh akses
     */
    private function authorizeManager()
    {
        if (auth()->user()->role !== 'manager') {
            abort(403, 'Akses ditolak.');
        }
    }
}
