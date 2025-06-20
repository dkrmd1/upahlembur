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
    Schema::table('karyawans', function (Blueprint $table) {
        $table->integer('upah_per_jam')->default(15000);
    });
}

public function down(): void
{
    Schema::table('karyawans', function (Blueprint $table) {
        $table->dropColumn('upah_per_jam');
    });
}
};
