<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table      = 'course';
    protected $primaryKey = 'id_course';

    // Map the default timestamp fields
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'modified_on';

    protected $fillable = [
        'course_name',
        'course_code'
    ];

    public function coachCourse()
    {
        return $this->hasMany(CoachCourse::class, 'course_id', 'id_course');
    }   
}
