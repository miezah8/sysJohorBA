<?php

// app/Models/SanctionDocument.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SanctionDocument extends Model
{
    protected $fillable = ['sanction_request_id','type','filename','path'];

    public function request()
    {
        return $this->belongsTo(SanctionRequest::class,'sanction_request_id');
    }
}
