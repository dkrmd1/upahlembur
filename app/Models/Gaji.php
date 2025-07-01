<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
    use HasFactory;

    protected $table = 'gajis'; // Optional: hanya jika tidak sesuai konvensi

    protected $fillable = [
        'karyawan_id',
        'bulan',
        'gaji_pokok',
        'perjalanan_dinas',
        'lembur',
        'bpjs_kes',
        'bpjs_tk',
        'bpjs_tk_perusahaan',
        'bpjs_kes_perusahaan', // ✅ Tambahkan ini
        'thr',
        'pakaian_dinas',
        'pph',
        'total',
    ];

    protected $casts = [
        'gaji_pokok'            => 'integer',
        'perjalanan_dinas'      => 'integer',
        'lembur'                => 'integer',
        'bpjs_kes'              => 'integer',
        'bpjs_tk'               => 'integer',
        'bpjs_tk_perusahaan'    => 'integer',
        'bpjs_kes_perusahaan'   => 'integer', // ✅ Tambahkan ini
        'thr'                   => 'integer',
        'pakaian_dinas'         => 'integer',
        'pph'                   => 'integer',
        'total'                 => 'integer',
        'bulan'                 => 'string',  // disimpan dalam format Y-m
    ];

    /**
     * Relasi ke model Karyawan.
     */
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}
