<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CaptchaResource;
use App\Models\Captcha;

class CaptchaController extends Controller
{
    public function generate(Request $request)
    {
        return new CaptchaResource(new Captcha());
    }

    public function verify(Request $request)
    {
        
    }
}
