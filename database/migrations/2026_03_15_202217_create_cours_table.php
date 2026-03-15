<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    public function up(): void{
        Schema::create('cours', function (Blueprint $table) {
            $table->id();
            $table->string('cours_name');
            $table->enum('cours_type', ['free','premium'])->default('free');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down(): void{
        Schema::dropIfExists('cours');
    }
};
