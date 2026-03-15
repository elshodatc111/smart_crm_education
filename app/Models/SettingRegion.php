<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SettingRegion extends Model{

    use SoftDeletes;

    protected $table = 'setting_regions';

    protected $fillable = [
        'region_code',
        'region_name',
        'created_by',
        'deleted_by'
    ];

    protected $hidden = [
        'deleted_at'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    public function creator(){
        return $this->belongsTo(User::class, 'created_by');
    }
    public function deleter(){
        return $this->belongsTo(User::class, 'deleted_by');
    }

}
