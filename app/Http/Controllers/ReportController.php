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
        // Ambil bulan & tahun dari query string, atau default saat ini
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        // Query rekap lembur per karyawan
        $laporan = Lembur::select(
                'karyawan_id',
                DB::raw('SUM(jam) as total_jam'),
                DB::raw('SUM(upah) as total_upah')
            )
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan)
            ->groupBy('karyawan_id')
            ->with('karyawan') // relasi ke model Karyawan
            ->get();

        // Hitung total keseluruhan
        $totalJam = $laporan->sum('total_jam');
        $totalUpah = $laporan->sum('total_upah');

        return view('laporan.index', compact('laporan', 'bulan', 'tahun', 'totalJam', 'totalUpah'));
    }
}
