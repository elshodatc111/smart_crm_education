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
}
