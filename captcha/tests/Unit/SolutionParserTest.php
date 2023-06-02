<?php

namespace Tests\Unit;

use App\Http\Business\KeyManager;
use Tests\TestCase;
use App\Http\Business\SolutionParser;
use InvalidArgumentException;

class SolutionParserTest extends TestCase
{

    protected string $solution = '012023123';
    protected array $target_class_images = [];

    public function test_parse_correct_encrypted_string(){
        $encrypted = SolutionParser::parseToEncryptedString($this->solution, $this->target_class_images);
        $captcha_img_solution = SolutionParser::parseFromEncryptedString($encrypted, KeyManager::getActiveKeyNumber());
        $this->assertEquals($this->solution, $captcha_img_solution->getSolution());
        $this->assertEquals($this->target_class_images, $captcha_img_solution->getTargetClassImages());
    }

    public function test_parse_from_wrong_encrypted_string() {
        $this->expectException(InvalidArgumentException::class);
        SolutionParser::parseFromEncryptedString("wrong_encrypted_string", KeyManager::getActiveKeyNumber());
    }


}
