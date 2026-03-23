<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDavomad extends Model{
    use HasFactory;
    protected $table = 'user_davomads';
    protected $fillable = [
        'group_id',
        'user_id',
        'date',
        'status',
        'created_by',
    ];
    protected $casts = [
        'date' => 'date',
        'created_at' => 'datetime',
    ];
    
    public function student(): BelongsTo{
        return $this->belongsTo(User::class, 'user_id');
    }
    public function group(): BelongsTo{
        return $this->belongsTo(Group::class, 'group_id');
    }
    public function creator(): BelongsTo{
        return $this->belongsTo(User::class, 'created_by');
    }
    public function scopeByDate($query, $date){
        return $query->where('date', $date);
    }
    public function scopeStatus($query, $status){
        return $query->where('status', $status);
    }
    public function getStatusBadgeAttribute(){
        $colors = [
            'keldi'    => 'success',
            'kelmadi'  => 'danger',
            'sababli'  => 'warning',
        ];
        $color = $colors[$this->status] ?? 'secondary';
        $text = ucfirst($this->status);
        return "<span class='badge bg-{$color}'>{$text}</span>";
    }
}
