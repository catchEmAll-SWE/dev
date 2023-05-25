<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Business\CaptchaImgBuilder;
use App\Http\Resources\V1\CaptchaImgResource;

class CaptchaController extends Controller
{
    public function generate(Request $request)
    {
        return CaptchaImgBuilder::getGenerator()->getCaptchaImg();
    }

    public function verify(Request $request)
    {
        
    }
}
