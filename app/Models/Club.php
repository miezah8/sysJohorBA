<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    protected $table = 'club';
    protected $primaryKey = 'id_club';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'sys_id',
        'club_name',
        'created_at',
        'modified_on',
        'email','phone','address','postcode','state','district',
    ];

    // Relationship: A club has many facilities
    public function facilities()
    {
        return $this->hasMany(ClubFacilities::class, 'club_id', 'id_club');
    }

    public function athletes()
    {
        return $this->hasMany(\App\Models\Athlete::class, 'club_id', 'id_club');
    }

    // Accessor for athletes count
    public function getJumlahPemainAttribute()
    {
        return $this->athletes()->count();
    }
}