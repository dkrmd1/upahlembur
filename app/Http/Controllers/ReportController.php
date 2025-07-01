<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lembur;
use App\Models\Karyawan;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');
        $karyawanId = $request->karyawan_id;

        // Ambil data lembur berdasarkan filter
        $query = Lembur::with('karyawan')
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan);

        if ($karyawanId) {
            $query->where('karyawan_id', $karyawanId);
        }

        $lemburData = $query->orderBy('tanggal')->get()->map(function ($item) {
            $item->hari = Carbon::parse($item->tanggal)->translatedFormat('l');
            return $item;
        });

        // Hitung total jam dan upah
        $totalJam = $lemburData->sum('jam');
        $totalUpah = $lemburData->sum('upah');

        // Ambil semua karyawan untuk filter
        $karyawans = Karyawan::all();

        return view('laporan.index', compact(
            'lemburData',
            'bulan',
            'tahun',
            'totalJam',
            'totalUpah',
            'karyawans',
            'karyawanId'
        ));
    }

    public function exportPdf(Request $request)
    {
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');
        $karyawanId = $request->karyawan_id;

        // Ambil ulang data lembur untuk export PDF
        $query = Lembur::with('karyawan')
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan);

        if ($karyawanId) {
            $query->where('karyawan_id', $karyawanId);
        }

        $lemburData = $query->orderBy('tanggal')->get()->map(function ($item) {
            $item->hari = Carbon::parse($item->tanggal)->translatedFormat('l');
            return $item;
        });

        $totalJam = $lemburData->sum('jam');
        $totalUpah = $lemburData->sum('upah');

        $pdf = Pdf::loadView('laporan.export-pdf', [
            'lemburData' => $lemburData,
            'bulan'      => $bulan,
            'tahun'      => $tahun,
            'totalJam'   => $totalJam,
            'totalUpah'  => $totalUpah,
        ]);

        return $pdf->download("laporan-lembur-{$bulan}-{$tahun}.pdf");
    }
}
