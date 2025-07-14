<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasColumn('settings', 'data')) {
            Schema::table('settings', function (Blueprint $table) {
                $table->json('data')->nullable()->after('value');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('settings', 'data')) {
            Schema::table('settings', function (Blueprint $table) {
                $table->dropColumn('data');
            });
        }
    }
};
