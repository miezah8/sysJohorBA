<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table = 'state'; // actual table name
    protected $primaryKey = 'id_state'; // custom primary key
    public $timestamps = false; // because you're not using Laravel's default timestamps

    protected $fillable = [
        'state_name',
        'state_code',
        'code_state',
    ];
    
}
