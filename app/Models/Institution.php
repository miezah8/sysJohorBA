<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    protected $table = 'ipt_list';
    protected $primaryKey = 'id';
    public $timestamps = true; // you have created_at & modified_on

    const UPDATED_AT = 'modified_on'; 

    protected $fillable = [
        'ipt_name',
        'ipt_type',
        'ipt_cat',
    ];

    /**
     * Polymorphic parent: athlete or coach (or any future model).
     */
    public function educationable()
    {
        return $this->morphTo();
    }

    /**
     * If you want, you can also define a helper to fetch the institution:
     */
    public function Education()
    {
        return $this->belongsTo(Education::class, 'institution_id', 'id');
    }
}
