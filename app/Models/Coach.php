<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Coach extends Model
{
    use HasFactory;

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

    /**
     * Accessor: full_name = "First Last"
     */
    public function getFullNameAttribute()
    {
        return trim("{$this->coach_fname} {$this->coach_lname}");
    }
    /**
     * A coach belongs to a club (if you track that relation).
     */
    public function club()
    {
        return $this->belongsTo(Club::class, 'club_id', 'id_club');
    }

    /**
     * A coach has many athletes.
     */
    public function athletes()
    {
        return $this->hasMany(Athlete::class, 'coach_id', 'id_coach');
    }

}
