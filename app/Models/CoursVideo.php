<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoursVideo extends Model{
    use SoftDeletes;
    protected $fillable = [
        'cours_id',
        'video_name',
        'video_url',
        'description',
        'sort_order'
    ];
    public function cours(){
        return $this->belongsTo(Cours::class);
    }
}
