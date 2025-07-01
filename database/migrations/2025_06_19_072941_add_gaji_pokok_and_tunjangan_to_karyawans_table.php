<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('karyawans', function (Blueprint $table) {
            if (!Schema::hasColumn('karyawans', 'gaji_pokok')) {
                $table->integer('gaji_pokok')->default(0)->after('jabatan');
            }

            if (!Schema::hasColumn('karyawans', 'tunjangan')) {
                $table->integer('tunjangan')->default(0)->after('gaji_pokok');
            }
        });
    }

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
