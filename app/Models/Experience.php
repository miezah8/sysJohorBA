<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $table      = 'experiences';
    protected $primaryKey = 'id_exp';

    // Map the default timestamp fields
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'modified_on';

    protected $fillable = [
        'tournament',
        'ranking',
        'category',
        'achieve_id',
        'year',
         // polymorphic keys…
        'experiencable_id',
        'experiencable_type',
    ];

    public function experiencable()
    {
        return $this->morphTo();
    }

    public function achievement()
    {
        return $this->belongsTo(\App\Models\Achievement::class,
                               'achieve_id',
                               'id_achieve');
    }
}
