<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    protected $table = 'achievement'; // actual table name
    protected $primaryKey = 'id_achieve'; // custom primary key
    public $timestamps = false; // because you're not using Laravel's default timestamps

    protected $fillable = [
        'achieve_code',
        'achieve_bm',
        'achieve_bi',
        'created_at',
        'modified_on',
    ];
}
