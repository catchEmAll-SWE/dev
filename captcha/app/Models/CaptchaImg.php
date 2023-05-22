<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\API\Ecryption\AES256Cipher;

class CaptchaImg extends Model
{
    use HasFactory;
    private string $id;
    private string $chosen_class;
    private array $images;
    private string $solution;

    public function __construct(string $choosen_class, array $images)
    {
        $this->chosen_class = $choosen_class;
        $this->images = $images;
        $this->id = $this->generateId();
        $this->solution = $this->generateSolution();
    }

    private function generateId() :string{
        // TODO check ids generation process
        $image_ids = "";
        foreach ($this->images as $image_for_class){
            foreach($image_for_class as $image){
                $image_ids .= $image->getField('id');
            }
        }
        return Hash::make($image_ids);
    }

    public function getId(){
        return $this->id;
    }

    public function getSolution(){
        return $this->generateSolution();
    }

    private function generateSolution(){
        $encryption_algorithm = new AES256Cipher();
        $solution = "";
        /*
        foreach ($this->images as $image_for_class){
            foreach($image_for_class as $image)
                $solution .= ($image->getField('class') == $this->chosen_class) ? $image->getField('id') : "";
        }
        //return $encryption_algorithm->encrypt($solution);
        */
        foreach ($this->images as $image_for_class){
            foreach($image_for_class as $image)
                $solution .= ($image->getField('class') == $this->chosen_class) ? "1" : "0";
        }
        return $encryption_algorithm->encrypt($solution);
    }
}
