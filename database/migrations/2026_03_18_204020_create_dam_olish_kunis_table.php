<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    public function up(): void{
        Schema::create('dam_olish_kunis', function (Blueprint $table) {
            $table->id();
            $table->date('data');
            $table->string('title');
            $table->timestamps();
            $table->softDeletes(); 
        });
    }
    public function down(): void{
        Schema::dropIfExists('dam_olish_kunis');
    }
};
