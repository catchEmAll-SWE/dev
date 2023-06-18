<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Business\Generate\CaptchaImgBuilder;

class CaptchaImgBuilderTest extends TestCase
{

    protected CaptchaImgBuilder $captcha_img_builder;

    protected function setUp(): void
    {
        parent::setUp();
        $this->captcha_img_builder = new CaptchaImgBuilder();
    }

    public function test_build_captcha_with_correct_target_images_reliability() : void {
        $images = $this->captcha_img_builder->createCaptchaImg()->getImages();
        $target_class = $images[9]->getField('class');
        $target_images = 0;
        $reliable_image = 0;
        foreach ($images as $image) {
            if ($image->getField('class') == $target_class){
                $target_images++;
                $rel = $image->getField('reliability');
                $reliable_image += ($image->getField('reliability') >= 80) ? 1 : 0;
            }
        }
        $this->assertTrue($reliable_image >= (intdiv($target_images,2) + 1));
    }

    public function test_build_captcha_with_correct_images_reliability() : void {
        $images = $this->captcha_img_builder->createCaptchaImg()->getImages();
        $simple_class = $images[0]->getField('class');
        $images_of_class = 0;
        $reliable_image_of_class = 0;
        foreach ($images as $image) {
            if ($image->getField('class') == $simple_class){
                $images_of_class++;
                $reliable_image_of_class += ($image->getField('reliability') >= 80) ? 1 : 0;
            }
        }
        
        $this->assertTrue($reliable_image_of_class >= intdiv($images_of_class,2));
    }

}
