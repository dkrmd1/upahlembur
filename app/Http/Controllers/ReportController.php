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

        $query = Lembur::with('karyawan')
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan);

        if ($karyawanId) {
            $query->where('karyawan_id', $karyawanId);
        }

        $lemburData = $query->orderBy('tanggal')->get()
            ->map(function ($item) {
                $item->hari = Carbon::parse($item->tanggal)->format('l');
                return $item;
            });

        $totalJam = $lemburData->sum('jam');
        $totalUpah = $lemburData->sum('upah');
        $karyawans = Karyawan::all();

        return view('laporan.index', compact('lemburData', 'bulan', 'tahun', 'totalJam', 'totalUpah', 'karyawans', 'karyawanId'));
    }

    public function exportPdf(Request $request)
    {
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        $data = $this->index($request)->getData();

        $pdf = Pdf::loadView('laporan.export-pdf', [
            'lemburData' => $data['lemburData'],
            'bulan'      => $bulan,
            'tahun'      => $tahun,
            'totalJam'   => $data['totalJam'],
            'totalUpah'  => $data['totalUpah'],
        ]);

        return $pdf->download("laporan-lembur-{$bulan}-{$tahun}.pdf");
    }
}
