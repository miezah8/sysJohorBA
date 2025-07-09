<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $table = 'user_detail';
    protected $primaryKey = 'id'; //prev: user_id

    protected $fillable = [
      'user_id','ic_no','nationality','address','postcode',
      'state_id','district_id','gender','race',
      'profile_picture','ic_picture'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
       //return $this->belongsTo(User::class);
    }

    public function state()
    {
      return $this->belongsTo(\App\Models\State::class,
                             'state_id',    // FK on user_detail
                             'id_state');   // PK on state
    }

    public function district()
    {
      return $this->belongsTo(\App\Models\District::class,
                             'district_id',
                             'id_district');
    }

    public function nationalityRelation()
    {
      return $this->belongsTo(\App\Models\Nationality::class,
                             'nationality',   // FK on user_detail
                             'id_nationality'); // PK on nationality
    }
}