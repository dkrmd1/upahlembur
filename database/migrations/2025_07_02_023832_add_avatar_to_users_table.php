<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'nip')) {
                $table->string('nip')->nullable()->after('email');
            }

            if (!Schema::hasColumn('users', 'group')) {
                $table->string('group')->nullable()->after('nip');
            }

            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('user')->after('group');
            }

            if (!Schema::hasColumn('users', 'avatar')) {
                $table->string('avatar')->nullable()->after('role');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'avatar')) {
                $table->dropColumn('avatar');
            }

            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }

            if (Schema::hasColumn('users', 'group')) {
                $table->dropColumn('group');
            }

            if (Schema::hasColumn('users', 'nip')) {
                $table->dropColumn('nip');
            }
        });
    }
};
