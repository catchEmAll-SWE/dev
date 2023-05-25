<?php

namespace App\Http\Business;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use App\Http\Business\Ecryption\AES256Cipher;
use Illuminate\Database\Eloquent\Collection;

class CaptchaImg extends Model
{
    use HasFactory;
    private string $id;
    private string $chosen_class;
    private Collection $images;

    public function __construct(string $choosen_class, Collection $images)
    {
        $this->chosen_class = $choosen_class;
        $this->images = $images;
        $this->id = $this->generateId();
    }

    private function generateId() :string{
        $captcha_id = "";
        foreach ($this->images as $image_for_class)
            $captcha_id .= $image_for_class;
        return Hash::make($captcha_id);
    }

    public function getId(){
        return $this->id;
    }

    public function getSolution(){
        return $this->generateSolution();
    }

    public function getImages(){
        return $this->images; 
    }

    private function generateSolution(){
        $encryption_algorithm = new AES256Cipher();
        $solution = "";
        
        foreach ($this->images as $image){
            $solution .= ($image->getField('class') == $this->chosen_class) ? "1" : "0";
        }
        return $encryption_algorithm->encrypt(SolutionConverter::convertToJsonString($solution));
    }
}
