<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoachCourse extends Model
{
    protected $table      = 'coach_course';
    protected $primaryKey = 'id_cco';
    public    $timestamps = false;

    protected $fillable = [
        'coach_id',
        'course_id',
        'course_level',
        'pass_date',
        'recognition',
        'cert_siri',
        'cert_attach',
    ];

    public function course()
    {
        return $this->belongsTo(\App\Models\Course::class,
                               'course_id',   // FK on coach_course
                               'id_course');  // PK on course
    }  
}
