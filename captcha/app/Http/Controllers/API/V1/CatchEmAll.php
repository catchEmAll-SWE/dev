<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CatchEmAll extends Controller
{
    public function generate(Request $request)
    {
        return "Hello World!";
    }
}
