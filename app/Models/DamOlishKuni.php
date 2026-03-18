<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DamOlishKuni extends Model{
    use SoftDeletes;
    protected $table = 'dam_olish_kunis';
    protected $fillable = [
        'data',
        'title',
    ];
    protected $casts = [
        'data' => 'date',
    ];
    public function scopeToday($query){
        return $query->whereDate('data', now());
    }
    public function scopeUpcoming($query){
        return $query->whereDate('data', '>=', now());
    }
    public function scopePast($query){
        return $query->whereDate('data', '<', now());
    }
    public function isToday(): bool{
        return $this->data->isToday();
    }
    public function isPast(): bool{
        return $this->data->isPast();
    }
}
