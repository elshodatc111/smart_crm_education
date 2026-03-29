<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSfmToken extends Model{
    protected $fillable = ['user_id', 'token', 'device_type'];
    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }
    public $incrementing = false; 
    protected $primaryKey = 'user_id';
}
