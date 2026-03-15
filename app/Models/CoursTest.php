<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoursTest extends Model{
    use SoftDeletes;
    protected $fillable = [
        'cours_id',
        'test_quez',
        'answer_a',
        'answer_b',
        'answer_c',
        'answer_d',
        'correct_answer'
    ];
    public function course(){
        return $this->belongsTo(Cours::class, 'cours_id');
    }
}
