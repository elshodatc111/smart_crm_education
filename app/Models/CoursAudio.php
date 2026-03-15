<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoursAudio extends Model{
    use SoftDeletes;
    protected $fillable = [
        'cours_id',
        'audio_name',
        'audio_url',
        'description',
        'sort_order'
    ];
    public function cours(){
        return $this->belongsTo(Cours::class);
    }
}
