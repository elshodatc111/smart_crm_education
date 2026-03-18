<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KassaSetting extends Model{
    protected $fillable = [
        'cash_exson',
        'card_exson',
        'cash_salary',
        'card_salary',
    ];
    public static function getSettings(): self{
        return self::firstOrCreate(
            [],
            [
                'cash_exson' => 0,
                'card_exson' => 0,
                'cash_salary' => 0,
                'card_salary' => 0,
            ]
        );
    }
}
