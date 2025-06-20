<?php

namespace App\Exports;

use App\Models\Lembur;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;

class LaporanLemburExport implements FromView
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
        $lemburData = Lembur::with('karyawan')
            ->whereYear('tanggal', $this->tahun)
            ->whereMonth('tanggal', $this->bulan)
            ->get();

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

        $totalJam = collect($laporan)->sum('total_jam');
        $totalUpah = collect($laporan)->sum('total_upah');

        return view('laporan.export-excel', [
            'laporan' => $laporan,
            'bulan' => $this->bulan,
            'tahun' => $this->tahun,
            'totalJam' => $totalJam,
            'totalUpah' => $totalUpah
        ]);
    }
}
