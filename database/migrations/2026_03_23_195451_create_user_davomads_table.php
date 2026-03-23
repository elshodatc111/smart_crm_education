<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    public function up(): void{
        Schema::create('user_davomads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group_id')->constrained('groups')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->date('date')->index(); 
            $table->enum('status',['keldi','kelmadi','sababli'])->default('keldi');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            $table->unique(['user_id', 'group_id', 'date'], 'student_attendance_unique');
        });
    }
    public function down(): void{
        Schema::dropIfExists('user_davomads');
    }
};
