<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\ImageDetails as V1ImageDetails;
use App\Http\Controllers\API\V1\ImageController;

class GenerateCaptchaImg{
    private static $generator = NULL;
    private CaptchaImgBuilder $captchaImgBuilder;

    private function __construct(){
        $this->captchaImgBuilder = new CaptchaImgBuilder(new ImageController());
    }

    public static function getGenerator(): GenerateCaptchaImg{
        if(self::$generator == NULL){
            self::$generator = new GenerateCaptchaImg();
        }
        return self::$generator;
    }

    public function getCaptchaImg(){
        $details = new V1ImageDetails();
        dd($this->captchaImgBuilder->buildCaptchaImg($details));
        return $this->captchaImgBuilder->buildCaptchaImg($details);
    }
}