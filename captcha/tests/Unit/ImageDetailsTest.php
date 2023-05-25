<?php

namespace Tests\Unit;

use App\Http\Business\ImageDetails;
use PHPUnit\Framework\TestCase;

class ImageDetailsTest extends TestCase
{
    protected ImageDetails $image_details;

    protected function setUp(): void
    {
        parent::setUp();
        $this->image_details = new ImageDetails();
    }

    public function test_number_of_classes_between_2_and_4(): void
    {
        $num_of_classes_per_captcha = $this->image_details->getNumberOfClasses();
        $this->assertEqualsWithDelta(3, $num_of_classes_per_captcha, 1);
    }

    public function test_number_of_images_for_class_between_2_and_7(): void
    {
        $imgs_for_class = $this->image_details->getNumberOfImagesForClass();
        foreach ($imgs_for_class as $num_of_images) {
            $this->assertGreaterThanOrEqual(2, $num_of_images);
            $this->assertLessThanOrEqual(7, $num_of_images);
        }
    }

    public function test_number_of_images_per_captcha_are_9(): void
    {
        $imgs_for_class = $this->image_details->getNumberOfImagesForClass();
        $this->assertEquals(9, array_sum($imgs_for_class));
    }
}
