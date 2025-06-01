<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Athlete extends Model
{
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

}
