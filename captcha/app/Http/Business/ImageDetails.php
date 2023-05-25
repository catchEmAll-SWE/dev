<?php

namespace App\Http\Business;

class ImageDetails{
    private int $num_of_classes;
    private array $imgs_for_class = [];

    public function __construct() {
        $this->num_of_classes = rand(2, 4);
        $this->imgs_for_class = $this->setNumberOfImagesForClass();
    }

    
    // Genera per ogni classe il numero di immagini che devono essere prese dal DB
    private function setNumberOfImagesForClass(): array{
        $imgs_for_class = [];
        $counter_chosen = $this->num_of_classes*2;
        for($i = 0; $i<$this->num_of_classes; $i++){
            $imgs_for_class[$i] = 2;
        }
        for($i = 0; $i<$this->num_of_classes-1; $i++){
            $imgs_for_class[$i] += rand(0, 9 - $counter_chosen);
            $counter_chosen += $imgs_for_class[$i]-2;
        }
        $imgs_for_class[$this->num_of_classes-1] += 9-$counter_chosen;
        return $imgs_for_class;
    }
    
    public function getNumberOfClasses(): int{
        return $this->num_of_classes;
    }

    public function getNumberOfImagesForClass(): array{
        return $this->imgs_for_class;
    }
}