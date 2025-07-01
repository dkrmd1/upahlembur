<?php

namespace App\Exports;

use App\Models\Gaji;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class GajiExport implements FromView
{
    protected $bulan;

    public function __construct($bulan)
    {
        $this->bulan = $bulan;
    }

    public function view(): View
    {
        $gajis = Gaji::with('karyawan')->where('bulan', $this->bulan)->get();

        return view('gaji.export-excel', [
            'gajis' => $gajis,
            'bulan' => $this->bulan
        ]);
    }
}
