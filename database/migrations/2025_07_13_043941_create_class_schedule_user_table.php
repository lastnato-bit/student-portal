<?php

// database/migrations/xxxx_xx_xx_create_class_schedule_user_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('class_schedule_user', function (Blueprint $table) {
            $table->foreignId('class_schedule_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->primary(['class_schedule_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('class_schedule_user');
    }
};
