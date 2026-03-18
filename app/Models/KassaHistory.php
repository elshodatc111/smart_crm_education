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
}
