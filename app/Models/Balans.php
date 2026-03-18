<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Balans extends Model{

    protected $table = 'balans';

    protected $fillable = [
        'cash',
        'card',
        'cash_salary',
        'card_salary',
        'cash_exson',
        'card_exson',
    ];
    
    protected $casts = [
        'cash' => 'decimal:2',
        'card' => 'decimal:2',
        'cash_salary' => 'decimal:2',
        'card_salary' => 'decimal:2',
        'cash_exson' => 'decimal:2',
        'card_exson' => 'decimal:2',
    ];

    public static function getBalans(): self{
        return self::firstOrCreate(
            [],
            [
                'cash' => 0,
                'card' => 0,
                'cash_salary' => 0,
                'card_salary' => 0,
                'cash_exson' => 0,
                'card_exson' => 0,
            ]
        );
    }
    
}
