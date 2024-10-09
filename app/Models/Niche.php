<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Niche extends Model
{
    use HasFactory;

protected $table = 'niches';


public function category(){
return $this->belongsTo(Category::class,'category_id');
}



}
