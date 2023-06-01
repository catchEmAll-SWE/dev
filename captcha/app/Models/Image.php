<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $fillable = ['id','class','reliability'];
    public $incrementing = false;
    public $timestamps = false;
    
    public function getField($field){
        return $this->{$field};
    }

    public function getImageSource() : string {
        $path = base_path() . "/database/DB_Images/" . $this->getField('class') . "/" . $this->getField('id');
        $file = fopen($path, 'r') or die("Unable to open file!");
        $img_in_base64 = fread($file, filesize($path));
        fclose($file);
        return $img_in_base64;
    }
}


