<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table = 'district'; // actual table name
    protected $primaryKey = 'id_district'; // custom primary key
    public $timestamps = false; // because you're not using Laravel's default timestamps

    protected $fillable = [
        'district_name',
        'state_id',
    ];
    
}
