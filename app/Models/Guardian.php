<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guardian extends Model
{
    use HasFactory;

    protected $table = 'guardians';      // or whatever your table is actually called
    protected $primaryKey = 'id_guardian';
    public $timestamps = false;         // if you’re not using created_at/updated_at

    protected $fillable = [
      'athlete_id',
      'name',
      'phone',
      'occupation',
      'relation',
      // etc
    ];

    // Relationship back to athlete:
    public function athlete()
    {
        return $this->belongsTo(Athlete::class, 'athlete_id', 'id_athlete');
    }
}
