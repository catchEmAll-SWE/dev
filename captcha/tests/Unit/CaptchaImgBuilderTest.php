<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Http\Business\CaptchaImgBuilder;

class CaptchaImgBuilderTest extends TestCase
{
    /**
     * A basic unit test example.
     */

    protected CaptchaImgBuilder $captcha_img_builder;
    protected function setUp(): void
    {
        parent::setUp();
        $this->captcha_img_builder = CaptchaImgBuilder::getGenerator();
    }
    public function test_minimun_reliability() : void
    {
        $captcha = $this->captcha_img_builder->getCaptchaImg();
    }
}
