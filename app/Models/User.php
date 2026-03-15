<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable{
    use HasApiTokens, Notifiable, SoftDeletes;
    protected $table = 'users';
    protected $fillable = [
        'role',
        'is_active',
        'name',
        'phone',
        'phone_alt',
        'balance',
        'birth_date',
        'address',
        'password',
        'created_by',
        'updated_by',
        'deleted_by'
    ];
    protected $hidden = [
        'password',
        'remember_token',
        'deleted_at'
    ];
    protected $casts = [
        'is_active' => 'boolean',
        'balance' => 'decimal:2',
        'birth_date' => 'date',
        'deleted_at' => 'datetime'
    ];
    protected $attributes = [
        'role' => 'user',
        'is_active' => true
    ];
    public function username(){
        return 'phone';
    }
    public function setPasswordAttribute($value){
        if ($value) {
            $this->attributes['password'] = Hash::make($value);
        }
    }
    public function creator(){
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updater(){
        return $this->belongsTo(User::class, 'updated_by');
    }
    public function deleter(){
        return $this->belongsTo(User::class, 'deleted_by');
    }
    protected static function boot(){
        parent::boot();
        static::creating(function ($model) {
            if (Auth::check()) {
                $model->created_by = Auth::id();
            }
        });
        static::updating(function ($model) {
            if (Auth::check()) {
                $model->updated_by = Auth::id();
            }
        });
        static::deleting(function ($model) {
            if (Auth::check()) {
                $model->deleted_by = Auth::id();
                $model->save();
            }
        });
    }
}