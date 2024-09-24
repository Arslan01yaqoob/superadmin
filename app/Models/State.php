<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $table = 'states';
    protected $guarded = [];

    public function country()
    {
        return $this->belongsTo(Countries::class, 'country_id');
    }

    public function cities()
    {
        return $this->hasMany(Cities::class, 'state_id');
    }
    
    

}
