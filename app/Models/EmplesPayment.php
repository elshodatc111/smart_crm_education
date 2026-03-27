<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmplesPayment extends Model{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'group_id',
        'amount',
        'payment_type',
        'description',
        'admin_id',
        'is_active',
    ];
    protected function casts(): array{
        return [
            'amount' => 'decimal:2',
            'is_active' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }
    public function user(): BelongsTo{
        return $this->belongsTo(User::class, 'user_id');
    }
    public function group(): BelongsTo{
        return $this->belongsTo(Group::class, 'group_id');
    }
    public function admin(): BelongsTo{
        return $this->belongsTo(User::class, 'admin_id');
    }
    public function getPaymentTypeLabelAttribute(): string{
        return $this->payment_type === 'cash' ? 'Naqd' : 'Plastik karta';
    }
}
