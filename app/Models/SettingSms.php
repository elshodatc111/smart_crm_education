<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingSms extends Model{
    protected $fillable = [
        'visit_sms',
        'payment_sms',
        'password_sms',
        'birthday_sms'
    ];
}
