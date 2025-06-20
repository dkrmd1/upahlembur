<?php

namespace App\Exports;

use App\Models\Karyawan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class KaryawanExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * Ambil semua data karyawan
     */
    public function collection()
    {
        return Karyawan::all();
    }

    /**
     * Judul kolom di file Excel
     */
    public function headings(): array
    {
        return [
            'NIP',
            'Nama',
            'Jabatan',
            'Gaji Pokok',
            'Tunjangan',
        ];
    }

    /**
     * Format setiap baris data (termasuk Rp dan titik)
     */
    public function map($karyawan): array
    {
        return [
            $karyawan->nip,
            $karyawan->nama,
            $karyawan->jabatan,
            'Rp ' . number_format($karyawan->gaji_pokok, 0, ',', '.'),
            'Rp ' . number_format($karyawan->tunjangan, 0, ',', '.'),
        ];
    }
}
