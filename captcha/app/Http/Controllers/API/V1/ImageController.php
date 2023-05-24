<?php

namespace App\Http\Controllers\API\V1;
use App\Models\Image;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;
use OutOfBoundsException;

class ImageController extends Controller
{
    public function getCaptchaClasses(int $num_of_classes) : array {
        if ($num_of_classes <= 0)
            throw new OutOfBoundsException("Number of classes must be positive");
        return Image::select('class')->distinct()->inRandomOrder()->limit($num_of_classes)->pluck('class')->toArray();
    }

    public function updateReliability(string $id, int $reliability) : void {
        Image::where('id', $id)->update(['reliability' => $reliability]);
    }

    public function getImagesIdOfClass (string $class, int $num_of_images) : Collection {
        return Image::where('class', $class)->inRandomOrder()->limit($num_of_images)->get();
    }
}
