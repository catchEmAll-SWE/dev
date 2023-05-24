<?php

namespace Tests\Unit;

use App\Http\Controllers\API\V1\ImageController;
use OutOfBoundsException;
use Tests\TestCase;

class ImageControllerTest extends TestCase
{
    protected ImageController $controller;

    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new ImageController();
    }

    public function test_classes_returned_are_in_not_empty_string_array() : void
    {
        $num_of_images = 3;
        $images = $this->controller->getCaptchaClasses($num_of_images);
        $this->assertNotEmpty($images);
        $this->assertIsArray($images);
        $this->assertContainsOnly('string', $images);
        $this->assertCount($num_of_images, $images);
    }

    public function test_get_negative_num_of_classes() : void
    {
        $this->expectException(OutOfBoundsException::class);
        $this->controller->getCaptchaClasses(-1);
    }
}
