<?php

namespace App\Http\Business\Verify;

use App\Http\Requests\VerifyCaptchaRequest;
use InvalidArgumentException;

class CaptchaVerifier {
    public static function verify(VerifyCaptchaRequest $request) : bool {
        try {
            //$pow_verifier = new POWVerifier($request->get('fixedStrings'), $request->get('nonces'));
            $img_verifier = new CaptchaImgVerifier($request->get('solution'), $request->get('response'), $request->get('keyNumber'));
            //return $pow_verifier->verify() && $img_verifier->verify();
            return $img_verifier->verify();
        } catch (InvalidArgumentException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}