<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professional extends Model
{
    use HasFactory;


    protected $table = 'professionals';
    protected $hidden = [
        'password',
        'device_tokken'
    ];


    protected $guarded = [
        'password'
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
    public function country()
    {
            return $this->belongsTo(Countries::class, 'country_id');
    }
    public function state()
    {
            return $this->belongsTo(State::class, 'state_id');
    }


    public function city()
    {
            return $this->belongsTo(Cities::class, 'city_id');
    }

    public function category(){

        return $this->belongsTo(Category::class,'business_category');

    }


}
