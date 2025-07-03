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
        Schema::table('gajis', function (Blueprint $table) {
            if (!Schema::hasColumn('gajis', 'tunjangan')) {
                $table->integer('tunjangan')->default(0)->after('gaji_pokok');
            }
        });

        Schema::table('gajis', function (Blueprint $table) {
            if (!Schema::hasColumn('gajis', 'rekening')) {
                $table->string('rekening')->nullable()->after('tunjangan');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gajis', function (Blueprint $table) {
            if (Schema::hasColumn('gajis', 'rekening')) {
                $table->dropColumn('rekening');
            }
        });

        Schema::table('gajis', function (Blueprint $table) {
            if (Schema::hasColumn('gajis', 'tunjangan')) {
                $table->dropColumn('tunjangan');
            }
        });
    }
};
