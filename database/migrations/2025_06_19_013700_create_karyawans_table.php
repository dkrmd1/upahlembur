<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Tambahkan kolom gaji_pokok dan tunjangan ke tabel karyawans
     */
    public function up(): void
    {
        Schema::table('karyawans', function (Blueprint $table) {
            if (!Schema::hasColumn('karyawans', 'gaji_pokok')) {
                $table->integer('gaji_pokok')->after('jabatan')->default(0);
            }
            if (!Schema::hasColumn('karyawans', 'tunjangan')) {
                $table->integer('tunjangan')->after('gaji_pokok')->default(0);
            }
        });
    }

    /**
     * Hapus kolom gaji_pokok dan tunjangan dari tabel karyawans
     */
    public function down(): void
    {
        Schema::table('karyawans', function (Blueprint $table) {
            if (Schema::hasColumn('karyawans', 'tunjangan')) {
                $table->dropColumn('tunjangan');
            }
            if (Schema::hasColumn('karyawans', 'gaji_pokok')) {
                $table->dropColumn('gaji_pokok');
            }
        });
    }
};
