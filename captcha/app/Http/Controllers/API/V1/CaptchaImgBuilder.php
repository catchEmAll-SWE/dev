<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\API\V1\ImageDetails;
use App\Http\Controllers\API\V1\ImageController;
use App\Http\Resources\V1\CaptchaImgResource;
use Illuminate\Database\Eloquent\Collection;
use App\Models\CaptchaImg;
use App\Models\Image;
use App\Models\Reliability;
use OutOfBoundsException;
use InvalidArgumentException;

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

    private function buildCaptchaImg(ImageDetails $imageDetails){
        $classes = $this->image_controller->getCaptchaClasses($imageDetails->getNumberOfClasses());
        
        $number_of_images_per_class = $imageDetails->getNumberOfImagesForClass();      
        foreach ($number_of_images_per_class as $index => $num_of_images){
            if($index == 0){
                $number_of_reliable_target_images = $number_of_images_per_class[$index] / 2 + 1;
                 $images = $this->getImages($classes[$index], $number_of_reliable_target_images, $number_of_images_per_class[$index] - $number_of_reliable_target_images);
            }        
            else{
                $number_of_reliable_non_target_images = $number_of_images_per_class[$index] / 2;
                $images = $this->getImages($classes[$index], $number_of_reliable_non_target_images, $number_of_images_per_class[$index] - $number_of_reliable_non_target_images);
            }       
        }
        $images->shuffle();
        return new CaptchaImg($classes[0], $images);
    }

    private function getImages(string $class, int $reliable_images, int $unreliable_images) : Collection {
        $images = new Collection();
        try{
            $images->push(...$this->image_controller->getImagesOfClass($class, $reliable_images, Reliability::Reliable));
            $images->push(...$this->image_controller->getImagesOfClass($class, $unreliable_images, Reliability::Unreliable));
        } catch(OutOfBoundsException | InvalidArgumentException $e){
            return $e->getMessage();
        }
        return $images;
    }

}