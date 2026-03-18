<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KassaHistory extends Model
{
    protected $fillable = [
        'amount',
        'type',
        'description',
        'manager_id',
        'status',
        'admin_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function meneger(){
        return $this->belongsTo(User::class, 'manager_id');
    }
    public function admin(){
        return $this->belongsTo(User::class, 'admin_id');
    }
}
