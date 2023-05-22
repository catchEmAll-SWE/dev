<?php

namespace App\Http\Resources\V1;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CaptchaImgResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'images' => ImageResource::collection($this->images),
            'solution' => $this->getSolution(),
            'keyNumber' => '10'
        ];
    }
}
