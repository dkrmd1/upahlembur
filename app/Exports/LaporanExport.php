<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanExport implements FromView
{
    protected $bulan;
    protected $tahun;

    public function __construct($bulan, $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    public function view(): View
    {
        $laporan = app('App\Http\Controllers\ReportController')->getLaporanData($this->bulan, $this->tahun);
        return view('laporan.export-excel', [
            'laporan' => $laporan,
            'bulan' => $this->bulan,
            'tahun' => $this->tahun,
        ]);
    }
}

