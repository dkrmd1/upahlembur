<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
    use HasFactory;

    protected $table = 'gajis'; // optional, jika nama tabel tidak standar

    protected $fillable = [
        'karyawan_id',
        'bulan',
        'gaji_pokok',
        'tunjangan',
        'rekening',
        'perjalanan_dinas',
        'lembur',
        'bpjs_kes',
        'bpjs_tk',
        'bpjs_tk_perusahaan',
        'bpjs_kes_perusahaan',
        'thr',
        'pakaian_dinas',
        'pph',
        'total',
    ];

    protected $casts = [
        'karyawan_id'           => 'integer',
        'gaji_pokok'            => 'integer',
        'tunjangan'             => 'integer',
        'rekening'              => 'string',
        'perjalanan_dinas'      => 'integer',
        'lembur'                => 'integer',
        'bpjs_kes'              => 'integer',
        'bpjs_tk'               => 'integer',
        'bpjs_tk_perusahaan'    => 'integer',
        'bpjs_kes_perusahaan'   => 'integer',
        'thr'                   => 'integer',
        'pakaian_dinas'         => 'integer',
        'pph'                   => 'integer',
        'total'                 => 'integer',
        'bulan'                 => 'string', // format 'Y-m'
    ];

    /**
     * Relasi ke model Karyawan.
     */
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}
