<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasColumn('karyawans', 'no_rekening')) {
            Schema::table('karyawans', function (Blueprint $table) {
                $table->string('no_rekening')->nullable()->after('bpjs_kes_perusahaan');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('karyawans', 'no_rekening')) {
            Schema::table('karyawans', function (Blueprint $table) {
                $table->dropColumn('no_rekening');
            });
        }
    }
};
