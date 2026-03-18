<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ChegirmaHistory extends Model{
    use SoftDeletes;
    protected $table = 'chegirma_histories';
    protected $fillable = [
        'group_id',
        'user_id',
        'group_user_id',
        'start_data',
        'end_data',
        'amount',
        'discount',
        'status',
    ];
    protected $casts = [
        'start_data' => 'date',
        'end_data' => 'date',
        'amount' => 'decimal:2',
        'discount' => 'decimal:2',
    ];
    public function group(){
        return $this->belongsTo(Group::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function group_user(){
        return $this->belongsTo(GroupUser::class);
    }
    public function scopeActive($query){
        return $query->where('status', 'success')->whereNull('end_data');
    }
    public function scopePending($query){
        return $query->where('status', 'pending');
    }
    public function scopeCanceled($query){
        return $query->where('status', 'cancel');
    }
    public function isActive(): bool{
        return $this->status === 'success' && is_null($this->end_data);
    }
    public function isExpired(): bool{
        return $this->end_data && $this->end_data->isPast();
    }
}
