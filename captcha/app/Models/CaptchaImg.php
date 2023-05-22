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

    public function __construct(string $choosen_class, array $images)
    {
        $this->chosen_class = $choosen_class;
        $this->images = $images;
        $this->id = $this->generateId();
    }

    private function generateId() :string{
        // TODO check ids generation process
        $image_ids = "";
        foreach ($this->images as $image){
            $image_ids .= $image->get('id');
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

        foreach ($this->images as $image)
            $solution .= ($image->getField('class') == $this->chosen_class) ? $image->getId() : "";
        
        return $encryption_algorithm->encrypt($solution);
    }
}
