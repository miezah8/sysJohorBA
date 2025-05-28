<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClubFacilities extends Model
{
    protected $table = 'club_facilities';
    protected $primaryKey = 'id_cf';
    public $timestamps = false;

    protected $fillable = [
        'club_id',
        'facility_type',
        'quantity',
        'created_at',
        'modified_on',
    ];

    // Relationship: Facility belongs to a club
    public function club()
    {
        return $this->belongsTo(Club::class, 'club_id', 'id_club');
    }
}

