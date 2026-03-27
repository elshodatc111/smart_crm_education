<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class GroupUser extends Model{
    use SoftDeletes;
    protected $fillable = [
        'group_id',
        'user_id',
        'is_active',
        'start_data',
        'start_comment',
        'start_admin_id',
        'end_data',
        'end_comment',
        'end_admin_id',
    ];
    protected $casts = [
        'is_active' => 'boolean',
        'start_data' => 'date',
        'end_data' => 'date',
    ];
    public function users(){
        return $this->hasMany(GroupUser::class, 'group_id');
    }
    public function group(){
        return $this->belongsTo(Group::class, 'group_id');
    }
    public function todayAttendance(){
        return $this->hasOne(UserDavomad::class, 'user_id', 'user_id')->where('group_id', $this->group_id)->whereDate('date', now()->toDateString());
    }
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
    public function startAdmin(){
        return $this->belongsTo(User::class, 'start_admin_id');
    }
    public function endAdmin(){
        return $this->belongsTo(User::class, 'end_admin_id');
    }
    public function scopeActive($query){
        return $query->whereNull('end_data');
    }
    public function scopeFinished($query){
        return $query->whereNotNull('end_data');
    }
    public function scopeByGroup($query, $groupId){
        return $query->where('group_id', $groupId);
    }
    public function scopeByUser($query, $userId){
        return $query->where('user_id', $userId);
    }
    public function isActive(): bool{
        return is_null($this->end_data);
    }
    public function isFinished(): bool{
        return !is_null($this->end_data);
    }
}
