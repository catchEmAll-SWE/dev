<?php

namespace App\Http\Business\Generate;

use Illuminate\Database\Eloquent\Collection;
use App\Http\Business\Enum\Reliability;
use OutOfBoundsException;
use InvalidArgumentException;
use App\Models\CaptchaImg;
use App\Http\Business\ImageService;

class CaptchaImgBuilder {
    
    private ImageDetails $details;
    public function __construct() {
        $this->details = new ImageDetails();
    }

    public function createCaptchaImg() : CaptchaImg {
        return $this->buildCaptchaImg($this->details);
    }

    private function buildCaptchaImg(ImageDetails $imageDetails) : CaptchaImg {
        if ($imageDetails == null)
            throw new InvalidArgumentException("ImageDetails cannot be null");
        $images = new Collection();
        try{
            $classes = ImageService::getAvailableClasses($imageDetails->getNumberOfClasses());
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
            $images->push(...ImageService::getImagesOfClass($classes[0], 1, Reliability::Reliable)); 
            return new CaptchaImg($images);
        } catch(OutOfBoundsException){
            return null;
        }
    }

    private function getImages(string $class, int $reliable_images, int $unreliable_images) : Collection {
        $images = new Collection();
        try{
            $images->push(...ImageService::getImagesOfClass($class, $reliable_images, Reliability::Reliable));
            $images->push(...ImageService::getImagesOfClass($class, $unreliable_images, Reliability::Unreliable));
        } catch(InvalidArgumentException $e){
            throw new InvalidArgumentException($e->getMessage()); 
        }
        return $images;
    }

}