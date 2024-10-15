<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Services_names extends Model
{
    use HasFactory;

protected $table = 'services_names';

public function niche(){

    return $this->belongsTo(Niche::class,'niche_id');
}

public function category(){

    return $this->belongsTo(Category::class,'category_id');

}


}
