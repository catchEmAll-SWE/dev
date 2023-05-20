<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Image;

class ImageService extends Controller
{
    private function getAvailableClasses() : array {
        $array = Image::select('class')->distinct()->get()->toArray();
        foreach($array as $key => $value){
            $array[$key] = $value['class'];
        }
        return $array;
    }

    public function getCaptchaClasses(int $num_of_classes) : array{
        $array = $this->getAvailableClasses();
        $captcha_classes = [];
        for($i = 0; $i<$num_of_classes; $i++){
            $rnd = rand(0,count($array)-1);
            $captcha_classes[$i] = $array[$rnd];
            array_splice($array, $rnd, 1);
        }
        return $captcha_classes;
    }

    public function updateReliability(string $id, int $reliability) : void{
        Image::where('id', $id)->update(['reliability' => $reliability]);
    }
}
