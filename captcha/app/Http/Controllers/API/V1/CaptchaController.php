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
    

    /**
     * @authenticated
     * @responseFile apiResponses/verify.json
     * 
     * @bodyParam fixedStrings string[] required The array composed of the three parts of the hashed id of the captcha, passed as api/v1/generate response. Example: [ "961fa7b4bc6af6f447ecd0" , "0635c63aadef1d4a1fd13" , "a51133975c8b385275f24" ]
     * @bodyParam nonces string[] required The array of characters that resolves the proof of work for the different fixed strings. Example: [ "12cd" , "23dwq" , "65faa" ]
     */
    public function verify(VerifyCaptchaRequest $request)
    {
        return CaptchaVerifier::verify($request) ? "true" : "false";
    }
}
