<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $table = 'education';
    protected $primaryKey = 'id_edu';
    public $timestamps = true; // you have created_at & modified_on

    protected $fillable = [
        'institution_id',
        'education_level',
        'year',
        'educationable_id',
        'educationable_type',
    ];

    /**
     * Polymorphic parent: athlete or coach (or any future model).
     */
    public function educationable()
    {
        return $this->morphTo();
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class,'institution_id','id');
    }
}
