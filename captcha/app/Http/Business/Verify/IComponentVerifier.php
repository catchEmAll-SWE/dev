<?php

namespace App\Http\Business\Verify;

interface IComponentVerifier {
    public function verify () : bool;
}