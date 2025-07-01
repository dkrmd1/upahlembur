<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::table('karyawans', function (Blueprint $table) {
            if (!Schema::hasColumn('karyawans', 'bpjs_kes_perusahaan')) {
                $table->integer('bpjs_kes_perusahaan')->nullable()->after('bpjs_tk_perusahaan');
            }
        });
    }

    /**
     * Batalkan migrasi.
     */
    public function down(): void
    {
        Schema::table('karyawans', function (Blueprint $table) {
            if (Schema::hasColumn('karyawans', 'bpjs_kes_perusahaan')) {
                $table->dropColumn('bpjs_kes_perusahaan');
            }
        });
    }
};
