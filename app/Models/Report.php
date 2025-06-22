<?php
// app/Models/Report.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = ['name','slug','parameters','created_by'];
    protected $casts   = ['parameters' => 'array'];

    public function creator()
    {
        return $this->belongsTo(User::class,'created_by');
    }
    
}