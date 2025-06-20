<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Lembur;

class DashboardController extends Controller
{
    public function index()
    {
        // Total Karyawan
        $totalKaryawan = Karyawan::count();

        // Ambil lembur bulan dan tahun saat ini
        $bulan = date('m');
        $tahun = date('Y');

        // Ambil data lembur bulan ini
        $lemburs = Lembur::with('karyawan')
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan)
            ->get();

        // Total Jam dan Upah Lembur
        $totalJam = $lemburs->sum('jam');
        $totalUpah = $lemburs->sum('upah');

        // Persiapkan data chart berdasarkan nama karyawan
        $grouped = $lemburs->groupBy(function ($item) {
            return $item->karyawan->nama ?? 'Tidak diketahui';
        });

        $chartLabels = $grouped->keys();
        $chartJam = $grouped->map(fn($g) => $g->sum('jam'))->values();
        $chartUpah = $grouped->map(fn($g) => $g->sum('upah'))->values();

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
