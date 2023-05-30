<?php

namespace Tests\Unit;

use App\Http\Business\ImageService;
use App\Models\Image;
use App\Http\Business\Enum\Reliability;
use InvalidArgumentException;
use OutOfBoundsException;
use Tests\TestCase;

class ImageServiceTest extends TestCase
{
    protected ImageService $controller;

    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new ImageService();
    }

    public function test_classes_returned_are_in_not_empty_string_array() : void
    {
        $num_of_classes = 3;
        $classes = $this->controller->getCaptchaClasses($num_of_classes);
        $this->assertNotEmpty($classes);
        $this->assertIsArray($classes);
        $this->assertContainsOnly('string', $classes);
        $this->assertCount($num_of_classes, $classes);
    }

    public function test_get_negative_num_of_classes() : void
    {
        $this->expectException(OutOfBoundsException::class);
        $this->controller->getCaptchaClasses(-1);
    }

    public function test_update_reliability() : void
    {
        $id = '-0tuJptj6F8';
        $reliability = Image::select('reliability')->where('id', $id)->pluck('reliability')->first();
        $this->controller->updateImageReliability($id, 1);
        $updated_reliability = Image::select('reliability')->where('id', $id)->pluck('reliability')->first();
        $this->assertEquals($reliability+1, $updated_reliability);
    }

    public function test_update_reliability_with_inexistent_image() : void
    {
        $id = 'inexistent image id';
        $reliability = Image::select('reliability')->where('id', $id)->pluck('reliability')->first();
        $this->controller->updateImageReliability($id, 1);
        $updated_reliability = Image::select('reliability')->where('id', $id)->pluck('reliability')->first();
        $this->assertEquals($reliability, $updated_reliability);
    }

    public function test_get_class_images() : void {
        $class = 'car';
        $num_of_images = 4;
        $reliability = Reliability::Reliable;
        
        $images = $this->controller->getImagesOfClass($class, $num_of_images, $reliability);
        $this->assertNotEmpty($images);
        $this->assertCount($num_of_images, $images);

        foreach($images as $image){
            $this->assertEquals($class, $image->class);
            $this->assertGreaterThanOrEqual(80, $image->reliability);
        }
    }

    public function test_get_images_of_undefined_class() : void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->controller->getImagesOfClass('undefined', 1, Reliability::Reliable);
    }

    public function test_request_more_images_of_a_class_than_available() : void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->controller->getImagesOfClass('car', 10000, Reliability::Reliable);
    }
}
