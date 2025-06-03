<?php

// app/Models/SanctionRequest.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SanctionRequest extends Model
{
    protected $fillable = [
      'user_id','state_ba_id','tournament_name','tournament_start_date','tournament_end_date',
      'venue_name','number_of_courts','venue_address','level','tournament_history',
      'organiser_name','pic_name','pic_mobile','pic_email',
      'status','remarks'
    ];

    public function organiser()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class,'state_ba_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function documents()
    {
        return $this->hasMany(SanctionDocument::class);
    }
}