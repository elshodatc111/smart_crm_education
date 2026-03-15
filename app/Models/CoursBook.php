<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoursBook extends Model{
    use SoftDeletes;
    protected $fillable = [
        'cours_id',
        'book_name',
        'book_url',
        'description'
    ];
    public function cours(){
        return $this->belongsTo(Cours::class);
    }
}
