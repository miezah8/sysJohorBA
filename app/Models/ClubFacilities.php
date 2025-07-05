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
        'facility_id',
        'quantity',
        'created_at',
        'modified_on',
    ];
    
    
    public function facilityType()
    {
        return $this->belongsTo(\App\Models\Facility::class,
                                'facility_id',     // FK on this table
                                'id'        // PK on facilities table
        );
    }

    // Relationship: Facility belongs to a club
    public function club()
    {
        return $this->belongsTo(Club::class, 'club_id', 'id_club');
    }
}

