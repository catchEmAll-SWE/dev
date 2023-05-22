<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $fillable = ['id','class','reliability'];
    public $incrementing = false;
    
    public function getField($field){
        return $this->{$field};
    }
}

