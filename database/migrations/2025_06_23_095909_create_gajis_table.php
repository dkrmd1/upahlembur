<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('gajis', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel karyawans
            $table->foreignId('karyawan_id')
                  ->constrained('karyawans')
                  ->onDelete('cascade');

            // Format bulan: string "YYYY-MM"
            $table->string('bulan', 7)->index(); // contoh: "2025-07"

            // Komponen gaji
            $table->bigInteger('gaji_pokok')->default(0);
            $table->bigInteger('perjalanan_dinas')->default(0);
            $table->bigInteger('lembur')->default(0);
            $table->bigInteger('thr')->default(0);
            $table->bigInteger('pakaian_dinas')->default(0);

            // Potongan karyawan
            $table->bigInteger('bpjs_kes')->default(0);
            $table->bigInteger('bpjs_tk')->default(0);
            $table->bigInteger('pph')->default(0);

            // Tanggungan perusahaan
            $table->bigInteger('bpjs_tk_perusahaan')->default(0);
            $table->bigInteger('ppn')->default(0);

            // Total akhir
            $table->bigInteger('total')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gajis');
    }
};
