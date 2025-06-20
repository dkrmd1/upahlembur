<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Lembur;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Total Karyawan
        $totalKaryawan = Karyawan::count();

        // Bulan dan Tahun sekarang
        $bulan = date('m');
        $tahun = date('Y');

        // Ambil data lembur bulan ini
        $lemburs = Lembur::with('karyawan')
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan)
            ->get();

        // Total Jam dan Upah
        $totalJam = $lemburs->sum('jam');
        $totalUpah = $lemburs->sum('upah');

        // CHART: Jam & Upah per Karyawan
        $grouped = $lemburs->groupBy(function ($item) {
            return $item->karyawan->nama ?? 'Tidak diketahui';
        });

        $chartLabels = $grouped->keys(); // ['Budi', 'Siti']
        $chartJam = $grouped->map(fn($g) => $g->sum('jam'))->values(); // [10, 8]
        $chartUpah = $grouped->map(fn($g) => $g->sum('upah'))->values(); // [150000, 120000]

        return view('index', compact(
            'totalKaryawan',
            'totalJam',
            'totalUpah',
            'chartLabels',
            'chartJam',
            'chartUpah'
        ));
    }
}
