<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model{
    use SoftDeletes;
    protected $fillable = [
        'cours_id',
        'room_id',
        'teacher_id',
        'payment_id',
        'group_name',
        'lesson_count',
        'group_type',
        'lesson_time',
        'teacher_pay',
        'teacher_bonus',
        'start_lesson',
        'admin_id',
    ];
    protected $casts = [
        'lesson_time' => 'datetime:H:i',
        'start_lesson' => 'date',
        'teacher_pay' => 'decimal:2',
        'teacher_bonus' => 'decimal:2',
    ];
    public function course(){
        return $this->belongsTo(Cours::class, 'cours_id');
    }
    public function room(){
        return $this->belongsTo(Classroom::class, 'room_id');
    }
    public function teacher(){
        return $this->belongsTo(User::class, 'teacher_id');
    }
    public function payment(){
        return $this->belongsTo(PaymentSetting::class, 'payment_id');
    }
    public function admin(){
        return $this->belongsTo(User::class, 'admin_id');
    }
    public function students(){
        return $this->hasMany(GroupUser::class, 'group_id');
    }
    public function lessons(){
        return $this->hasMany(GroupData::class, 'group_id');
    }
    public function scopeActive($query){
        return $query->whereNull('deleted_at');
    }
    public function scopeByTeacher($query, $teacherId){
        return $query->where('teacher_id', $teacherId);
    }
    public function isToq(): bool{
        return $this->group_type === 'toq';
    }
    public function isJuft(): bool{
        return $this->group_type === 'juft';
    }
    public function isAll(): bool{
        return $this->group_type === 'all';
    }
}
