<?php

namespace App\Exports;

use App\Models\Karyawan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KaryawanExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Karyawan::select(
            'nip',
            'nama',
            'jabatan',
            'group',
            'gaji_pokok',
            'tunjangan',
            'bpjs_tk',
            'bpjs_kes',
            'bpjs_tk_perusahaan',
            'bpjs_kes_perusahaan',
            'no_rekening' // ✅ Tambahkan kolom rekening
        )->get();
    }

    public function headings(): array
    {
        return [
            'NIP',
            'Nama',
            'Jabatan',
            'Group',
            'Gaji Pokok',
            'Tunjangan',
            'BPJS TK (Karyawan)',
            'BPJS Kes (Karyawan)',
            'BPJS TK (Perusahaan)',
            'BPJS Kes (Perusahaan)',
            'No Rekening', // ✅ Heading rekening
        ];
    }
}
