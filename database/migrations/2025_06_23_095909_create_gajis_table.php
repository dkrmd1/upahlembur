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
            $table->unsignedBigInteger('karyawan_id');
            $table->string('bulan'); // Format: YYYY-MM

            $table->bigInteger('gaji_pokok')->default(0);
            $table->bigInteger('perjalanan_dinas')->default(0);
            $table->bigInteger('lembur')->default(0);
            $table->bigInteger('bpjs_kes')->default(0);
            $table->bigInteger('bpjs_tk')->default(0);
            $table->bigInteger('bpjs_tk_perusahaan')->default(0);
            $table->bigInteger('thr')->default(0);
            $table->bigInteger('pakaian_dinas')->default(0);
            $table->bigInteger('pph')->default(0);
            $table->bigInteger('ppn')->default(0);

            $table->bigInteger('total')->default(0);

            $table->timestamps();

            $table->foreign('karyawan_id')
                  ->references('id')
                  ->on('karyawans')
                  ->onDelete('cascade');
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
