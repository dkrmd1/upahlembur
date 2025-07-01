<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('gajis', 'bpjs_kes_perusahaan')) {
            Schema::table('gajis', function (Blueprint $table) {
                $table->integer('bpjs_kes_perusahaan')->nullable()->after('bpjs_tk_perusahaan');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('gajis', 'bpjs_kes_perusahaan')) {
            Schema::table('gajis', function (Blueprint $table) {
                $table->dropColumn('bpjs_kes_perusahaan');
            });
        }
    }
};
