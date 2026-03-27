<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsLog extends Model{
    use HasFactory;
    protected $fillable = [
        'phone',
        'message',
        'sms_id',
        'status',
    ];
    public function getStatusLabelAttribute(): string{
        return match ($this->status) {
            'waiting'   => 'Kutilmoqda',
            'delivered' => 'Yetkazildi',
            'failed'    => 'Xatolik',
            default     => 'Noma\'lum',
        };
    }
}
