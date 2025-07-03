<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Lembur;
use App\Models\Gaji;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Total Karyawan
        $totalKaryawan = Karyawan::count();

        // Ambil bulan & tahun saat ini
        $bulanSekarang = Carbon::now()->format('Y-m'); // format '2025-07'

        // Ambil data lembur bulan ini
        $lemburs = Lembur::with('karyawan')
            ->whereYear('tanggal', Carbon::now()->year)
            ->whereMonth('tanggal', Carbon::now()->month)
            ->get();

        $totalJam = $lemburs->sum('jam');
        $totalUpah = $lemburs->sum('upah');

        // Ambil data gaji bulan ini (format 'Y-m')
        $gajis = Gaji::where('bulan', $bulanSekarang)->get();

        // Total Gaji bulan ini (jika ada)
        $totalGaji = $gajis->sum('total');

        return view('index', compact(
            'totalKaryawan',
            'totalJam',
            'totalUpah',
            'totalGaji'
        ));
    }
}
