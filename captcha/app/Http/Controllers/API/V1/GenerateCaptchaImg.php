<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\ImageDetails;
use App\Http\Controllers\API\V1\ImageController;
use App\Http\Resources\V1\CaptchaImgResource;
use Illuminate\Database\Eloquent\Collection;
use App\Models\CaptchaImg;

class GenerateCaptchaImg {
    private static $generator = NULL;
    private ImageController $image_controller;

    private function __construct(){
        $this->image_controller = new ImageController();
    }

    public static function getGenerator(): GenerateCaptchaImg{
        if(self::$generator == NULL){
            self::$generator = new GenerateCaptchaImg();
        }
        return self::$generator;
    }

    public function getCaptchaImg() : CaptchaImgResource {
        $details = new ImageDetails();
        return new CaptchaImgResource($this->buildCaptchaImg($details));
    }

    public function buildCaptchaImg(ImageDetails $imageDetails){
        $classes = $this->image_controller->getCaptchaClasses($imageDetails->getNumberOfClasses());
        $images = new Collection();
        foreach ($imageDetails->getNumberOfImagesForClass() as $index => $num_of_images)
            $images->push(...$this->image_controller->getImagesIdOfClass($classes[$index], $num_of_images));
        
        $images->shuffle();
        return new CaptchaImg($classes[0], $images);
    }
}