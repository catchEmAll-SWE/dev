<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    public function getId($id){
        return $this->{$id};
    }

    public function getClass($class){
        return $this->{$class};
    }

    public function getImgPath($path){
        return $this->{$path};
    }

    public function getReliability($reliability){
        return $this->{$reliability};
    }
}
