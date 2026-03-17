<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentSetting extends Model{
    use SoftDeletes;
    protected $table = 'payment_settings';
    protected $fillable = [
        'payment',
        'discount',
        'discount_day',
        'created_by',
    ];
    protected $casts = [
        'payment' => 'decimal:2',
        'discount' => 'decimal:2',
        'discount_day' => 'integer',
    ];
    public function user(){
        return $this->belongsTo(User::class, 'created_by');
    }
}
