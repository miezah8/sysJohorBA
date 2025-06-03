<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Athlete extends Model
{

    use HasFactory;
    
    protected $table      = 'athlete';    // actual table name
    protected $primaryKey = 'id_athlete'; // custom primary key
    public $timestamps    = false;        // because you're not using Laravel's default timestamps

    protected $fillable = [
        'user_id',
        'sys_id',
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

    public function coachAthletes()
    {
        return $this->belongsTo(Coach::class, 'coach_id', 'id_coach');
    }
 
    /**
     * Accessor: full_name = "First Last"
     */
    public function getFullNameAttribute()
    {
        return trim("{$this->athlete_fname} {$this->athlete_lname}");
    }
     /**
     * An athlete belongs to a single club.
     */
    public function club()
    {
        return $this->belongsTo(Club::class, 'club_id', 'id_club');
    }

    /**
     * An athlete belongs to a single coach.
     */
    public function coach()
    {
        return $this->belongsTo(Coach::class, 'coach_id', 'id_coach');
    }


}
