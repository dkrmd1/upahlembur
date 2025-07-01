<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('karyawans', function (Blueprint $table) {
            if (!Schema::hasColumn('karyawans', 'bpjs_tk_perusahaan')) {
                $table->integer('bpjs_tk_perusahaan')->default(0)->after('bpjs_kes');
            }
        });
    }

    public function down(): void
    {
        Schema::table('karyawans', function (Blueprint $table) {
            if (Schema::hasColumn('karyawans', 'bpjs_tk_perusahaan')) {
                $table->dropColumn('bpjs_tk_perusahaan');
            }
        });
    }
};
