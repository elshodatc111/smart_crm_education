<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cours extends Model{
    use SoftDeletes;
    protected $fillable = [
        'cours_name',
        'cours_type',
        'description'
    ];
    public function videos(){
        return $this->hasMany(CoursVideo::class);
    }
    public function audios(){
        return $this->hasMany(CoursAudio::class);
    }
    public function books(){
        return $this->hasMany(CoursBook::class);
    }
    public function tests(){
        return $this->hasMany(CoursTest::class);
    }
}
