<?php

namespace Tests\Unit;

use App\Http\Business\Verify\CaptchaVerifier;
use App\Http\Requests\VerifyCaptchaRequest;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class CaptchaVerifierTest extends TestCase
{
    /**
     * test captcha con solution = 'no sense string'
     */
    protected VerifyCaptchaRequest $verify_captcha_request;

    protected function setUp(): void
    {
        parent::setUp();
        $this->verify_captcha_request = new VerifyCaptchaRequest();
    }

    public function test_verify_captcha_invalid_solution(){
        $this->expectException(InvalidArgumentException::class);
        CaptchaVerifier::verify($this->verify_captcha_request);
    }
}
