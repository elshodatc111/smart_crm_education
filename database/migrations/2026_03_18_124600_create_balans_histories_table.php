<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration{
    public function up(): void{
        Schema::create('balans_histories', function (Blueprint $table) {
            $table->id();
            $table->enum('type', [
                'kirim_cash','kirim_card','kirim_exson_cash','kirim_exson_card','kirim_ish_haqi_cash','kirim_ish_haqi_card',
                'xarajat_kassa_cash','xarajat_kassa_card','xarajat_balans_cash','xarajat_balans_card',
                'chiqim_cash','chiqim_card','chiqim_exson',
                'cash_to_ishhaqi','card_to_ishhaqi',
                'ishhaqi_to_cash','ishhaqi_to_card',
                'ishhaqi_pay_cash','ishhaqi_pay_card',
            ]);
            $table->decimal('amount', 15, 2);
            $table->string('description')->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('admin_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void{
        Schema::dropIfExists('balans_histories');
    }
};
