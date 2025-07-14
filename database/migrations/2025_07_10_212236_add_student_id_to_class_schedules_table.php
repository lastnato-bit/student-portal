<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('class_schedules', function (Blueprint $table) {
        $table->unsignedBigInteger('student_id')->after('id')->nullable();

        $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('class_schedules', function (Blueprint $table) {
        $table->dropForeign(['student_id']);
        $table->dropColumn('student_id');
    });
}
};
