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
        Schema::table('class_schedules', function (Blueprint $table) {
            // First drop the existing 'subject' column if it exists
            if (Schema::hasColumn('class_schedules', 'subject')) {
                $table->dropColumn('subject');
            }

            // Add the course_id foreign key
            $table->foreignId('course_id')
                ->nullable()
                ->constrained()
                ->after('section_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('class_schedules', function (Blueprint $table) {
            // Drop the foreign key and column
            $table->dropConstrainedForeignId('course_id');

            // Add back the 'subject' column
            $table->string('subject')->nullable()->after('section_id');
        });
    }
};
