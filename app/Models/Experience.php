<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $fillable = [
        'tournament',
        'stage',
        'category',
        'year',
        'achievement_id',
    ];

    public function experiencable()
    {
        return $this->morphTo();
    }

    public function achievement()
    {
        return $this->belongsTo(\App\Models\Achievement::class,
                               'achievement_id',
                               'id_achieve');
    }
}
