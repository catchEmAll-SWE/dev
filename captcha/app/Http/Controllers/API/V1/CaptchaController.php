<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\VerifyCaptchaRequest;
use App\Http\Resources\V1\CaptchaResource;
use App\Models\Captcha;
use App\Http\Business\Verify\CaptchaVerifier;

class CaptchaController extends Controller
{
    /**
    * @authenticated
    * @responseFile apiResponses/generate.json
    * 
    * @responseField captchaImg object Contains all information to create captcha image
    * @responseField src string Image in base64 format
    * @responseField solution string Captcha image solution
    * @responseField keyNumber integer Number of key used to encrypt the solution
    * @responseField proofOfWorkDetails object Contains all info rmation to create proof of work
    * @responseField fixedString string[] Array of string to be used in proof of work as fixed part
    * @responseField difficulty int Number of diffulty's zeros 
    */
    public function generate(Request $request)
    {
        return new CaptchaResource(new Captcha());
    }

    public function verify(VerifyCaptchaRequest $request)
    {
        return CaptchaVerifier::verify($request) ? "true" : "false";
    }
}
