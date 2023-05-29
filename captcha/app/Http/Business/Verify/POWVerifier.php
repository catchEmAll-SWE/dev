<?php

namespace App\Http\Business\Verify;

use Illuminate\Support\Facades\Hash;
use App\Http\Business\ProofOfWorkDetails;

class POWVerify {
    // PRECONDITION: $fixed_strings and $nonces are arrays of strings with 3 elements
    public static function isPOWCorrect(array $fixed_strings, array $nonces) : bool {
        $difficulty = ProofOfWorkDetails::getDifficulty();
        foreach ($fixed_strings as $index => $fixed_string) {
            if (substr(Hash::make($fixed_string + $nonces[$index]), 0, $difficulty) != '00') 
                return false;
        }
        return true;
    }
    // POSTCONDITION: returns true if nonces provided generate hashcodes with 2 leading zeros
}