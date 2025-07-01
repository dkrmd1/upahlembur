<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('karyawans', function (Blueprint $table) {
            $table->string('group')->nullable()->after('jabatan');
            $table->integer('bpjs_tk')->default(0)->after('tunjangan');
            $table->integer('bpjs_kes')->default(0)->after('bpjs_tk');
        });
    }

    public function down(): void
    {
        Schema::table('karyawans', function (Blueprint $table) {
            $table->dropColumn(['group', 'bpjs_tk', 'bpjs_kes']);
        });
    }
};
