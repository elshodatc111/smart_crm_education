<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BalansHistory extends Model{

    protected $fillable = [
        'type',
        'amount',
        'description',
        'user_id',
        'admin_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];
    
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function admin(){
        return $this->belongsTo(User::class, 'admin_id');
    }

}
