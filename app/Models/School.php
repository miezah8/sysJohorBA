<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $table = 'school'; // actual table name
    protected $primaryKey = 'id_school'; // custom primary key
    public $timestamps = false; // because you're not using Laravel's default timestamps

    protected $fillable = [
        'school_name',
        'sch_code',
        'sc_address',
        'postcode',
        'district_id',
        'state_id',
        'no_tel',
        'no_fax',
        'email_sch',
        'created_at',
        'modified_on',
    ];

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'id_state');
    }

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id', 'id_district');
    }
 

}
