<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class PaymentSpecial extends Model{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'amount',
        'discount',
        'description',
        'admin_id',
    ];
    protected $casts = [
        'amount'   => 'decimal:2',
        'discount' => 'decimal:2',
    ];
    public function admin(): BelongsTo{
        return $this->belongsTo(User::class, 'admin_id');
    }
}
