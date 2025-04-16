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
        Schema::create('data', function (Blueprint $table) {
            $table->id();
            $table->string('cifid')->nullable();
            $table->string('sre')->nullable();
            $table->string('sid')->nullable();
            $table->string('nama')->nullable();
            $table->string('nik_ktp')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('penghasilan_rata_rata_per_tahun')->nullable();
            $table->string('sumber_penghasilan')->nullable();
            $table->string('rdn')->nullable();
            $table->string('bank_pribadi')->nullable();
            $table->string('no_rekening_pribadi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data');
    }
};
