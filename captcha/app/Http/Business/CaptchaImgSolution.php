<?php

namespace App\Http\Business;

use JsonSerializable;

class CaptchaImgSolution implements JsonSerializable {
    private string $solution;
    private array $target_class_images;

    public function __construct(string $encrypted_solution, array $target_class_images) 
    {
        $this->solution = $encrypted_solution;
        $this->target_class_images = $target_class_images;
    }

    public function jsonSerialize() {
        return [
            'solution' => $this->solution,
            'targetClassImagesId' => $this->target_class_images,
            'time' => time()
        ];
    }

    public function getSolution() : string {
        return $this->solution;
    }

    public function getTargetClassImages() : array {
        return $this->target_class_images;
    }
}