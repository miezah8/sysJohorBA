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
    protected $table      = 'user_detail';    // your actual table name
    protected $primaryKey = 'user_id';        // your PK is user_id
    public $incrementing  = false;            // because it’s not an auto‐incrementing id
    public $timestamps    = true;             // you already have created_at & updated_at

    protected $fillable = [
      'ic_no',
      'nationality',
      'address',
      'postcode',
      'district_id',
      'state_id',
      'gender',
      'race',
      'profile_picture',
      'ic_picture',
    ];

    public function user()
    {
      return $this->belongsTo(User::class, 'user_id');
    }
}