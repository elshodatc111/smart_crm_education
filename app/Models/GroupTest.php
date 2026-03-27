<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GroupTest extends Model{
    use HasFactory;
    protected $fillable = [
        'group_id',
        'cours_id',
        'user_id',
        'savollar',
        'togri_javob',
        'ball',
    ];
    protected function casts(): array{
        return [
            'savollar' => 'integer',
            'togri_javob' => 'integer',
            'ball' => 'integer',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
    public function group(): BelongsTo{
        return $this->belongsTo(Group::class);
    }
    public function course(): BelongsTo{
        return $this->belongsTo(Cours::class, 'cours_id');
    }
    public function user(): BelongsTo{
        return $this->belongsTo(User::class);
    }
    public function getPercentageAttribute(): float|int{
        if ($this->savollar <= 0) {
            return 0;
        }
        return round(($this->togri_javob / $this->savollar) * 100, 2);
    }
}
