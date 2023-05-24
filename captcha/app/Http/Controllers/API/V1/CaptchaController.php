<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\V1\CaptchaImgResource;

class CaptchaController extends Controller
{
    public function generate(Request $request)
    {
        return GenerateCaptchaImg::getGenerator()->getCaptchaImg();
    }

    public function verify(Request $request)
    {
        
    }
}
