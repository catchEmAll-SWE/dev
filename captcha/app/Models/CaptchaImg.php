<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use App\Http\Business\SolutionParser;

class CaptchaImg
{
    private string $id;
    private string $chosen_class;
    private Collection $images;

    // PRE: $images is a collection of 10 images
    public function __construct(Collection $images)
    {
        $this->chosen_class = $images[9]->getField('class');
        $this->images = $images;
        $this->id = $this->generateId();
    }

    private function generateId() :string{
        $captcha_id = "";
        foreach ($this->images as $image_for_class)
            $captcha_id .= $image_for_class;
        return hash("sha256", $captcha_id);
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
        $target_images = [];
        $solution = "";  
        for ($i = 0; $i < 9; $i++){
            $image = $this->images[$i];
            $img_class = $image->getField('class');
            if($img_class == $this->chosen_class){
                $solution .= ($image->getField('reliability')>=80) ? "1" : "0";
                array_push($target_images, $image->getField('id'));
            }else{
                $solution .= ($image->getField('reliability')>=80) ? "3" : "2";
            }
        }
        return SolutionParser::parseToEncryptedString($solution, $target_images);
    }
}
