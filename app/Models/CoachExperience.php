<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoachExperience extends Model
{
    protected $table      = 'coach_experience';
    protected $primaryKey = 'id_exp';

    // Map the default timestamp fields
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'modified_on';

    protected $fillable = [
        'coach_id',
        'activity',
        'position',
        'level',
        'organized_by',
        'start_date',
        'end_date',
    ];


}
