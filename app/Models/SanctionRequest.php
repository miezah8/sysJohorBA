<?php

// app/Models/SanctionRequest.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SanctionRequest extends Model
{
    protected $fillable = [
      'user_id','state_ba_id','tournament_name','tournament_date',
      'venue_name','number_of_courts','venue_address','level',
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

    public function documents()
    {
        return $this->hasMany(SanctionDocument::class);
    }
}