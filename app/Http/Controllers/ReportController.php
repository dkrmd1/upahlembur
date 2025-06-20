<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lembur;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        // Ambil semua data lembur bulan-tahun tertentu
        $lemburData = Lembur::with('karyawan')
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan)
            ->get();

        // Rekap data per karyawan
        $laporan = [];

        foreach ($lemburData->groupBy('karyawan_id') as $karyawanId => $items) {
            $totalJam = 0;
            $totalUpah = 0;
            $hariKerjaJam = 0;
            $hariLiburJam = 0;
            $hariKerjaUpah = 0;
            $hariLiburUpah = 0;
            $karyawan = $items->first()->karyawan;

            foreach ($items as $item) {
                $hari = Carbon::parse($item->tanggal)->format('l');
                $isLibur = in_array($hari, ['Saturday', 'Sunday']);

                $totalJam += $item->jam;
                $totalUpah += $item->upah;

                if ($isLibur) {
                    $hariLiburJam += $item->jam;
                    $hariLiburUpah += $item->upah;
                } else {
                    $hariKerjaJam += $item->jam;
                    $hariKerjaUpah += $item->upah;
                }
            }

            $laporan[] = (object)[
                'karyawan' => $karyawan,
                'total_jam' => $totalJam,
                'total_upah' => $totalUpah,
                'hari_kerja_jam' => $hariKerjaJam,
                'hari_libur_jam' => $hariLiburJam,
                'hari_kerja_upah' => $hariKerjaUpah,
                'hari_libur_upah' => $hariLiburUpah,
            ];
        }

        // Total semua jam & upah
        $totalJam = collect($laporan)->sum('total_jam');
        $totalUpah = collect($laporan)->sum('total_upah');

        return view('laporan.index', compact('laporan', 'bulan', 'tahun', 'totalJam', 'totalUpah'));
    }
}
