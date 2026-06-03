<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserMission extends Model
{
    protected $fillable = [
        'user_id',
        'mission_id',
        'completed',
        'claimed',
        'completed_at'
    ];

    public function mission()
    {
        return $this->belongsTo(Mission::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
