<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sections', function (Blueprint $table) {
            // Make sure the column exists and is the correct type
            $table->unsignedBigInteger('department_id')->nullable()->change();

            // Then apply the foreign key constraint
            $table->foreign('department_id')
                ->references('id')
                ->on('departments')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('sections', function (Blueprint $table) {
            $table->dropForeign(['department_id']);
            // Don't drop column if already used, unless really needed
            // $table->dropColumn('department_id');
        });
    }
};
