<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nip',
        'jabatan',
        'gaji_pokok',
        'tunjangan',
    ];

    /**
     * Relasi: Karyawan memiliki banyak data lembur
     */
    public function lemburs()
    {
        return $this->hasMany(Lembur::class);
    }

    /**
     * Accessor untuk menghitung upah per jam
     * Rumus: (Gaji Pokok + Tunjangan) / 173
     */
    public function getUpahPerJamAttribute(): float
    {
        return round(($this->gaji_pokok + $this->tunjangan) / 173, 2);
    }
}
