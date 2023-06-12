<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Business\Verify\CaptchaImgVerifier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\VerifyCaptchaRequest;
use App\Http\Resources\V1\CaptchaResource;
use App\Models\Captcha;
use App\Http\Business\Verify\CaptchaVerifier;
use App\Http\Business\Verify\CaptchaJsonResultGenerator;
use App\Http\Business\Verify\POWVerifier;

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
    public function generate(Request $request) : CaptchaResource
    {
        $captcha = $this->getNewCaptcha();
        $captcha->save();
        return new CaptchaResource($captcha);
    }

    private function getNewCaptcha () : Captcha {
        $captcha = new Captcha();
        $max_attemps = 5;
        while(Captcha::find($captcha->id) && $max_attemps-- > 0)
            $captcha = new Captcha();

        return $captcha;
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
        $fixed_strings = $request->get('fixedStrings');

        $verifier = new CaptchaVerifier([
            new POWVerifier($fixed_strings, $request->get('nonces')),
            new CaptchaImgVerifier($request->get('solution'), $request->get('response'), $request->get('keyNumber'))
        ]);

        if ($this->isActiveCaptcha($this->captchaIdFromFixedStrings($fixed_strings))){
            if ($verifier->isUserResponseRight())
                return CaptchaJsonResultGenerator::createHumanResult();
            return CaptchaJsonResultGenerator::createBotResult();
        }
        //otherwise
        return response()->json(['message' => 'Captcha not found or invalid'], 404);
    }

    private function captchaIdFromFixedStrings (array $fixed_strings) : string {
        return implode('', $fixed_strings);
    }

    private function isActiveCaptcha (string $captcha_id) : bool {
        return Captcha::select('hashed_id')->where('hashed_id', $captcha_id)->get()->count() == 1;
    }


}
