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
    Schema::table('instructors', function (Blueprint $table) {
        if (!Schema::hasColumn('instructors', 'lastname')) {
            $table->string('lastname');
        }

        if (!Schema::hasColumn('instructors', 'firstname')) {
            $table->string('firstname');
        }

        if (!Schema::hasColumn('instructors', 'middlename')) {
            $table->string('middlename')->nullable();
        }

        if (!Schema::hasColumn('instructors', 'email')) {
            $table->string('email')->unique();
        }

        if (!Schema::hasColumn('instructors', 'contact_number')) {
            $table->string('contact_number')->nullable();
        }

        if (!Schema::hasColumn('instructors', 'department_id')) {
            $table->foreignId('department_id')->nullable()->constrained()->onDelete('cascade');
        }
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('instructors', function (Blueprint $table) {
        $table->dropColumn(['lastname', 'firstname', 'middlename', 'email', 'contact_number']);
        $table->dropForeign(['department_id']);
        $table->dropColumn('department_id');
    });
}

};
