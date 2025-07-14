<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('class_schedules', function (Blueprint $table) {
            $table->dropForeign(['student_id']); // in case it's a foreign key
            $table->dropColumn('student_id');
        });
    }

    public function down(): void
    {
        Schema::table('class_schedules', function (Blueprint $table) {
            $table->unsignedBigInteger('student_id')->nullable(); // or notNullable() if you need it
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
        });
    }
};
