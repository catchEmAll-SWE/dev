<?php

namespace Tests\Unit;

use App\Http\Business\CaptchaImgSolution;
use PHPUnit\Framework\TestCase;

class CaptchaImgSolutionTest extends TestCase
{
    /**
     * A basic unit test example.
     */

    protected CaptchaImgSolution $captcha_img_solution;

    protected function setUp() : void {
        parent::setUp();
        $this->captcha_img_solution = new CaptchaImgSolution("133220303", array("Zqy-x7K5Qcg","loUlSOXL81c","p6ZWMgiiE5c"));
    }
    public function test_serialize_json(){
        $json = json_encode($this->captcha_img_solution);
        $this->assertTrue(str_contains($json, '{"solution":"133220303","targetClassImagesId":["Zqy-x7K5Qcg","loUlSOXL81c","p6ZWMgiiE5c"],'));
    }
}
