<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\ImageDetails as V1ImageDetails;
use App\Models\Image;

class GenerateCaptchaImg{
    private static $generator = NULL;

    private function __construct(){}

    public static function getGenerator(): GenerateCaptchaImg{
        if(self::$generator == NULL){
            self::$generator = new GenerateCaptchaImg();
        }
        return self::$generator;
    }

    public function getCaptchaImg(){
        $details = new V1ImageDetails();
        
        // return captcha image
    }
}