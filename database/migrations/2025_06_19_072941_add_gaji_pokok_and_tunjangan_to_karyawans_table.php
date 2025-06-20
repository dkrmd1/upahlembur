<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('karyawans', function (Blueprint $table) {
            $table->integer('gaji_pokok')->default(0)->after('jabatan');
            $table->integer('tunjangan')->default(0)->after('gaji_pokok');
        });
    }

    public function down(): void
    {
        Schema::table('karyawans', function (Blueprint $table) {
            $table->dropColumn(['gaji_pokok', 'tunjangan']);
        });
    }
};

