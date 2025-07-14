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
    Schema::table('grades', function (Blueprint $table) {
        $table->unsignedBigInteger('class_schedule_id')->nullable()->after('student_id');
        $table->foreign('class_schedule_id')->references('id')->on('class_schedules')->onDelete('set null');
    });
}

public function down()
{
    Schema::table('grades', function (Blueprint $table) {
        $table->dropForeign(['class_schedule_id']);
        $table->dropColumn('class_schedule_id');
    });
}
};
