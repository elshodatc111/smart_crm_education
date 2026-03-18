<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    public function up(): void{
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cours_id')->constrained('cours')->cascadeOnDelete();
            $table->foreignId('room_id')->constrained('classrooms')->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('payment_id')->constrained('payment_settings')->cascadeOnDelete();
            $table->string('group_name');
            $table->integer('lesson_count');
            $table->enum('group_type', ['toq', 'juft', 'all']);
            $table->time('lesson_time');
            $table->decimal('teacher_pay', 15, 2)->default(0);
            $table->decimal('teacher_bonus', 15, 2)->default(0);
            $table->date('start_lesson');
            $table->foreignId('admin_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down(): void{
        Schema::dropIfExists('groups');
    }
};
