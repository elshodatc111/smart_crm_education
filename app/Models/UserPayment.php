<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserPayment extends Model{
    use SoftDeletes;
    protected $table = 'user_payments';
    protected $fillable = [
        'user_id',
        'group_id',
        'type',
        'amount',
        'discount',
        'payment_type',
        'status',
        'description',
        'admin_id',
    ];
    protected $casts = [
        'amount' => 'decimal:2',
        'discount' => 'decimal:2',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function group(){
        return $this->belongsTo(Group::class);
    }
    public function admin(){
        return $this->belongsTo(User::class, 'admin_id');
    }
    public function scopeSuccess($query){
        return $query->where('status', 'success');
    }
    public function scopePending($query){
        return $query->where('status', 'pending');
    }
    public function scopeCanceled($query){
        return $query->where('status', 'cancel');
    }
    public function scopePayments($query){
        return $query->where('type', 'payment');
    }
    public function scopeRefunds($query){
        return $query->where('type', 'refund');
    }
    public function getRealAmountAttribute(){
        return $this->amount - $this->discount;
    }
    public function isSuccess(): bool{
        return $this->status === 'success';
    }
    public function isPending(): bool{
        return $this->status === 'pending';
    }
    public function isRefund(): bool{
        return $this->type === 'refund';
    }
}
