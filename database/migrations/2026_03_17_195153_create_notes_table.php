<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    public function up(): void{
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->integer('note_id');
            $table->enum('type',['user','emploes','groups']);
            $table->string('text');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void{
        Schema::dropIfExists('notes');
    }
};
