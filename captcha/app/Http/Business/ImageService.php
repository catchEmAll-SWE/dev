<?php

namespace App\Http\Business;
use App\Models\Image;
use App\Models\Reliability;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;
use OutOfBoundsException;

class ImageService {
    public function getCaptchaClasses(int $num_of_classes) : array {
        if ($num_of_classes <= 0)
            throw new OutOfBoundsException("Number of classes must be positive");
        return Image::select('class')->distinct()->inRandomOrder()->limit($num_of_classes)->pluck('class')->toArray();
    }

    public function updateImageReliability(string $id, float $offset) : void {
        $reliability_updated = Image::select('reliability')->where('id', $id)->pluck('reliability')->first() + $offset;
        Image::where('id', $id)->update(['reliability' => $reliability_updated]);
    }

    public function getImagesOfClass (string $class, int $num_of_images, Reliability $reliability) : Collection {
        if ($reliability == Reliability::Reliable) 
            $images = Image::where('class', $class)->where('reliability', '>=', 80)->inRandomOrder()->limit($num_of_images)->get();
        else
            $images = Image::where('class', $class)->where('reliability', '<', 80)->inRandomOrder()->limit($num_of_images)->get();
        if (count($images) < $num_of_images)
            throw new InvalidArgumentException("Number of images of class $class is less than $num_of_images");
        return $images;
    }
}
