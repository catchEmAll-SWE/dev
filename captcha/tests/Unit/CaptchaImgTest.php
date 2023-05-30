<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\CaptchaImg;
use App\Http\Business\Enum\Reliability;
use App\Http\Business\ImageService;
use App\Http\Business\KeyManager;
use App\Http\Business\SolutionParser;

class CaptchaImgTest extends TestCase
{
    protected CaptchaImg $captcha_img;

    protected function setUp() : void {
        parent::setUp();
        $service = new ImageService();
        $images = $service->getImagesOfClass("car", 3, Reliability::Reliable);
        $images->push(...$service->getImagesOfClass("car", 2, Reliability::Unreliable));
        $images->push(...$service->getImagesOfClass("laptop", 2, Reliability::Reliable));
        $images->push(...$service->getImagesOfClass("laptop", 3, Reliability::Unreliable));
        $this->captcha_img = new CaptchaImg($images);
    }

    // test solution correctness
    public function test_solution_correctness(): void
    {
        $solution = SolutionParser::parseFromEncryptedString(
            $this->captcha_img->getSolution(), KeyManager::getActiveKeyNumber());
        
        $this->assertEquals($solution->getSolution(), "111003322");
    }
}
