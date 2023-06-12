<?php

namespace App\Http\Business\Verify;

/**
 * @throws InvalidArgumentException
 */

interface IComponentVerifier {
    public function verify () : bool;
}