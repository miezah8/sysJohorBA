<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Athlete extends Model
{
    use HasFactory;

    protected $table      = 'athlete';
    protected $primaryKey = 'id_athlete';
    public $timestamps    = false;

    protected $fillable = [
        'user_id',
        'coach_id',
        'school_id',
        'club_id',
        'athlete_fname',
        'athlete_lname',
        'tshirt_size',
        'shirt_name',
        'created_at',
        'modified_on',
    ];

    // RELATIONSHIPS

    /** Link back to the main User record */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }

    /** One‐to‐one guardian (by shared sys_id) */
    public function guardian()
    {
        return $this->hasOne(\App\Models\Guardian::class, 'athlete_id', 'id_athlete');
    }

    /** School info */
    public function school()
    {
        return $this->belongsTo(\App\Models\School::class, 'school_id', 'id_school');
    }

    /** Club info */
    public function club()
    {
        return $this->belongsTo(\App\Models\Club::class, 'club_id', 'id_club');
    }

    /** Coach info */
    public function coach()
    {
        return $this->belongsTo(\App\Models\Coach::class, 'coach_id', 'id_coach');
    }

    /** All of this athlete’s tournament results */
    public function experiences()
    {
        return $this->morphMany(\App\Models\Experience::class, 'experiencable');
    }

    // ACCESSORS

    /** “First Last” */
    public function getFullNameAttribute()
    {
        return trim("{$this->athlete_fname} {$this->athlete_lname}");
    }
}
