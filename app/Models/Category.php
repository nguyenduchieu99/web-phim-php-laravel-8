<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = false; //set time to false
    use HasFactory;

    //Một danh mục có nhiều phim. :hasMany
    public function movie() {
        return $this->hasMany(Movie::class)->orderBy('id','DESC');
    }
}
