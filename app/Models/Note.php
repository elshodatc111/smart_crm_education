<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model{
    protected $table = 'notes';
    protected $fillable = [
        'note_id',
        'type',
        'text',
        'created_by',
    ];
    protected $casts = [
        'note_id' => 'integer',
        'type' => 'string',
    ];
    public function user(){
        return $this->belongsTo(User::class, 'created_by');
    }
}
