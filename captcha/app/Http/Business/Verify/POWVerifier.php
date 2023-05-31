<?php

namespace App\Http\Business\Verify;

use App\Http\Business\ProofOfWorkDetails;

class POWVerifier {
    private array $fixed_strings;
    private array $nonces;

    public function __construct(array $fixed_strings, array $nonces)
    {
        $this->fixed_strings = $fixed_strings;
        $this->nonces = $nonces;
    }
    // PRECONDITION: $fixed_strings and $nonces are arrays of strings with 3 elements
    public function verify() : bool {
        foreach ($this->fixed_strings as $index => $fixed_string) {
            $hashcode = hash("sha256", $fixed_string . $this->nonces[$index]);
            if (!str_starts_with($hashcode, ProofOfWorkDetails::getDifficulty())){
                return false;
            }   
        }
        return true;
    }
    // POSTCONDITION: returns true if nonces provided generate hashcodes with 2 leading zeros
}