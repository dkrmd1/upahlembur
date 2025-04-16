<?php

namespace App\Imports;

use App\Models\Data;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PenghasilanImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Data([
            'cifid' => $row['cifid'],
            'sre' => $row['sre'],
            'sid' => $row['sid'],
            'nama' => $row['nama'],
            'nik_ktp' => $row['nik_ktp'],
            'pekerjaan' => $row['pekerjaan'],
            'penghasilan_rata_rata_per_tahun' => $row['penghasilan_rata_rata_per_tahun'],
            'sumber_penghasilan' => $row['sumber_penghasilan'],
            'rdn' => $row['rdn'],
            'bank_pribadi' => $row['bank_pribadi'],
            'no_rekening_pribadi' => $row['no_rekening_pribadi'],
        ]);
    }
}
