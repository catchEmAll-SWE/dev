<?php

namespace App\Http\Business\Verify;

use App\Http\Requests\VerifyCaptchaRequest;
use InvalidArgumentException;

class CaptchaVerifier {
    private VerifyCaptchaRequest $request;

    public function __construct(VerifyCaptchaRequest $request) {
        $this->request = $request;
    }
    public function verify() : bool {
        try {
            $pow_verifier = new POWVerifier($this->request->get('fixedStrings'), $this->request->get('nonces'));
            $img_verifier = new CaptchaImgVerifier($this->request->get('solution'), $this->request->get('response'), $this->request->get('keyNumber'));
            return $pow_verifier->verify() && $img_verifier->verify();
        } catch (InvalidArgumentException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getIdOfCaptchaToVerify () : string {
        $fixedStrings = $this->request->get('fixedStrings');
        return $fixedStrings[0] . $fixedStrings[1] . $fixedStrings[2];
    }
}