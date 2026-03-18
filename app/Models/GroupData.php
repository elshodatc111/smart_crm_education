<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class GroupData extends Model{
    use SoftDeletes;
    protected $table = 'group_data';
    protected $fillable = [
        'group_id',
        'data',
        'time',
    ];
    protected $casts = [
        'data' => 'date',
        'time' => 'datetime:H:i',
    ];
    public function group(){
        return $this->belongsTo(Group::class, 'group_id');
    }
    public function scopeToday($query){
        return $query->whereDate('data', now());
    }
    public function scopeUpcoming($query){
        return $query->whereDate('data', '>=', now());
    }
    public function scopePast($query){
        return $query->whereDate('data', '<', now());
    }
    public function scopeByGroup($query, $groupId){
        return $query->where('group_id', $groupId);
    }
    public function isToday(): bool{
        return $this->data->isToday();
    }
    public function isPast(): bool{
        return $this->data->isPast();
    }
}
