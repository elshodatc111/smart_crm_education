<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kassa extends Model{
    protected $fillable = [
        'cash',
        'card',
        'output_cash_pending',
        'output_card_pending',
        'cost_cash_pending',
        'cost_card_pending',
    ];
    protected $casts = [
        'cash' => 'decimal:2',
        'card' => 'decimal:2',
        'output_cash_pending' => 'decimal:2',
        'output_card_pending' => 'decimal:2',
        'cost_cash_pending' => 'decimal:2',
        'cost_card_pending' => 'decimal:2',
    ];
    public static function getSettings(): self{
        return self::firstOrCreate(
            [],
            [
                'cash' => 0,
                'card' => 0,
                'output_cash_pending' => 0,
                'output_card_pending' => 0,
                'cost_cash_pending' => 0,
                'cost_card_pending' => 0,
            ]
        );
    }
}
