<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawans';

    protected $fillable = [
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
        'no_rekening', // tambahkan ini
    ];

    protected $casts = [
        'gaji_pokok'             => 'integer',
        'tunjangan'              => 'integer',
        'bpjs_tk'                => 'integer',
        'bpjs_kes'               => 'integer',
        'bpjs_tk_perusahaan'     => 'integer',
        'bpjs_kes_perusahaan'    => 'integer',
        'no_rekening'            => 'string', // tambahkan ini
    ];

    /**
     * Relasi: Karyawan memiliki banyak lembur.
     */
    public function lemburs()
    {
        return $this->hasMany(Lembur::class);
    }

    /**
     * Relasi: Karyawan memiliki banyak gaji.
     */
    public function gajis()
    {
        return $this->hasMany(Gaji::class);
    }

    /**
     * Accessor: Hitung upah per jam.
     */
    public function getUpahPerJamAttribute(): float
    {
        $total = $this->gaji_pokok + $this->tunjangan;
        return $total > 0 ? round($total / 173, 2) : 0;
    }

    /**
     * Hitung total lembur dalam bulan tertentu (format Y-m).
     */
    public function getTotalLemburBulan(string $bulan): float
    {
        $totalJam = $this->lemburs()
            ->where('tanggal', 'like', "$bulan%")
            ->sum('jam');

        return round($totalJam * $this->upah_per_jam, 2);
    }
}
