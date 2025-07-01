<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lembur extends Model
{
    use HasFactory;

    protected $table = 'lemburs'; // opsional, tambahkan jika nama tabel tidak standar pluralisasi Laravel

    protected $fillable = [
        'karyawan_id',
        'tanggal',
        'jam',
        'upah',
    ];

    protected $casts = [
        'tanggal' => 'date:Y-m-d',
        'jam'     => 'float',
        'upah'    => 'float',
    ];

    /**
     * Relasi: Lembur milik satu Karyawan
     */
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}
