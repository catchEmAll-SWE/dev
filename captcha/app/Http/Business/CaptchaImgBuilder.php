<?php

namespace App\Http\Business;

use App\Http\Controllers\API\V1\ImageController;
use App\Http\Resources\V1\CaptchaImgResource;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Reliability;
use OutOfBoundsException;
use InvalidArgumentException;

class CaptchaImgBuilder {
    private static $generator = NULL;
    private ImageController $image_controller;

    private function __construct(){
        $this->image_controller = new ImageController();
    }

    public static function getGenerator(): CaptchaImgBuilder{
        if(self::$generator == NULL){
            self::$generator = new CaptchaImgBuilder();
        }
        return self::$generator;
    }

    public function getCaptchaImg() : CaptchaImgResource {
        $details = new ImageDetails();
        return new CaptchaImgResource($this->buildCaptchaImg($details));
    }

    private function buildCaptchaImg(ImageDetails $imageDetails){
        $images = new Collection();
        $classes = $this->image_controller->getCaptchaClasses($imageDetails->getNumberOfClasses());
        foreach ($imageDetails->getNumberOfImagesForClass() as $index => $num_of_images){
            if($index == 0){
                $number_of_reliable_target_images = intdiv($num_of_images,2) + 1;
                $images->push(...$this->getImages($classes[$index], $number_of_reliable_target_images, $num_of_images - $number_of_reliable_target_images));
            }        
            else{
                $number_of_reliable_non_target_images = intdiv($num_of_images,2);
                $images->push(...$this->getImages($classes[$index], $number_of_reliable_non_target_images, $num_of_images - $number_of_reliable_non_target_images));
            }       
        }
        $images = $images->shuffle();
        $images->push(...$this->image_controller->getImagesOfClass($classes[0], 1, Reliability::Reliable));
        return new CaptchaImg($classes[0], $images);
    }

    private function getImages(string $class, int $reliable_images, int $unreliable_images) : Collection {
        $images = new Collection();
        try{
            $images->push(...$this->image_controller->getImagesOfClass($class, $reliable_images, Reliability::Reliable));
            $images->push(...$this->image_controller->getImagesOfClass($class, $unreliable_images, Reliability::Unreliable));
        } catch(OutOfBoundsException | InvalidArgumentException $e){
            throw new InvalidArgumentException($e->getMessage()); 
        }
        return $images;
    }

}