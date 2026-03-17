<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserHistory extends Model{
    protected $table = 'user_histories';

    protected $fillable = [
        'user_id',
        'type',
        'description',
        'created_by',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'type' => 'string',
    ];
    
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function creator(){
        return $this->belongsTo(User::class, 'created_by');
    }
}
