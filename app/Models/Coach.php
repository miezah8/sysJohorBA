<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Coach extends Model
{
    protected $table      = 'coach';    // actual table name
    protected $primaryKey = 'id_coach'; // custom primary key
    public $timestamps    = false;      // because you're not using Laravel's default timestamps

    protected $fillable = [
        'user_id',
        'club_id',
        'coach_fname',
        'coach_lname',
        'created_at',
        'modified_on',
    ];

    public function athletesCoach()
    {
        return $this->hasMany(Athlete::class, 'coach_id', 'id_coach');
    }

}
