<?php

namespace App\Http\Business\Verify;

use InvalidArgumentException;

class CaptchaVerifier {
    private array $verifiers;

    public function __construct(array $verifiers) {
        $this->verifiers = $verifiers;
    }
    public function isUserResponseRight() : bool {
        try {
            foreach ($this->verifiers as $verifier) 
                if (!$verifier->verify()) 
                    return false;
            return true;
        } 
        catch (InvalidArgumentException $e) {
            echo $e->getMessage();
            return false;
        }
    }
}