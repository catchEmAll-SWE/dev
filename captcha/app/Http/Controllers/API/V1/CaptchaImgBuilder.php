<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\ImageController;
use App\Models\CaptchaImg;

class CaptchaImgBuilder {
    private ImageController $imageController;

    public function __construct(ImageController $imageController){
        $this->imageController = $imageController;
    }

    public function buildCaptchaImg(ImageDetails $imageDetails){
        $classes = $this->imageController->getCaptchaClasses($imageDetails->getNumberOfClasses());
        $images = [];
        foreach ($imageDetails->getNumberOfImagesForClass() as $index => $num_of_images)
            array_push($images, $this->imageController->getImagesOfClass($classes[$index], $num_of_images));

        return new CaptchaImg($classes[0], $images);
    }
}