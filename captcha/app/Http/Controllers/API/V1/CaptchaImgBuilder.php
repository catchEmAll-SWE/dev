<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\ImageController;
use App\Models\CaptchaImg;
use Illuminate\Database\Eloquent\Collection;

class CaptchaImgBuilder {
    private ImageController $imageController;

    public function __construct(ImageController $imageController){
        $this->imageController = $imageController;
    }

    public function buildCaptchaImg(ImageDetails $imageDetails){
        $classes = $this->imageController->getCaptchaClasses($imageDetails->getNumberOfClasses());
        $images = new Collection();
        foreach ($imageDetails->getNumberOfImagesForClass() as $index => $num_of_images)
            $images->push(...$this->imageController->getImagesIdOfClass($classes[$index], $num_of_images));
        
        $images->shuffle();
        return new CaptchaImg($classes[0], $images);
    }
}