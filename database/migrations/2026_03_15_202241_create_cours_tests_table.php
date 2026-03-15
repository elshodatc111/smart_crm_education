<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    public function up(): void{
        Schema::create('cours_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cours_id')->constrained('cours')->cascadeOnDelete();
            $table->text('test_quez');
            $table->string('answer_a');
            $table->string('answer_b');
            $table->string('answer_c');
            $table->string('answer_d');
            $table->enum('correct_answer', ['a','b','c','d']);
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down(): void{
        Schema::dropIfExists('cours_tests');
    }
};
