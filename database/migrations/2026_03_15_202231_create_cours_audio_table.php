<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    public function up(): void{
        Schema::create('cours_audio', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cours_id')->constrained('cours')->cascadeOnDelete();
            $table->string('audio_name');
            $table->string('audio_url');
            $table->text('description')->nullable();
            $table->integer('sort_order')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void{
        Schema::dropIfExists('cours_audio');
    }
};
