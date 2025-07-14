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
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn('name');
        $table->string('lastname');
        $table->string('firstname');
        $table->string('middlename')->nullable();
    });

    Schema::table('students', function (Blueprint $table) {
        $table->dropColumn('name');
        $table->string('lastname');
        $table->string('firstname');
        $table->string('middlename')->nullable();
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['lastname', 'firstname', 'middlename']);
        $table->string('name');
    });

    Schema::table('students', function (Blueprint $table) {
        $table->dropColumn(['lastname', 'firstname', 'middlename']);
        $table->string('name');
    });
}
};
