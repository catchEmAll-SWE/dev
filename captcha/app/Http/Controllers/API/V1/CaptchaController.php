<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CaptchaResource;
use App\Models\Captcha;

class CaptchaController extends Controller
{
    /**
    * @response {
    *   "data": {
    *      "captchaImg": {
    *          "images": [
    *              {
    *                  "src" : "image0inbase64"
    *              },
    *              {
    *                  "src" : "image1inbase64"
    *              },
    *              {
    *                  "src" : "image2inbase64"
    *              },
    *              {
    *                  "src" : "image3inbase64"
    *              },
    *              {
    *                   "src" : "image4inbase64"
    *              },
    *              {
    *                   "src" : "image5inbase64"
    *              },
    *              {
    *                   "src" : "image6inbase64"
    *              },
    *              {
    *                   "src" : "image7inbase64"
    *              },
    *              {
    *                   "src" : "image8inbase64"
    *              },
    *              {
    *                   "src" : "image9inbase64"
    *              },
    *           ],
    *           "solution": "eyJpdiI6ImtkS3BaaXExZmlDOUxwVDEzZ01Fb1E9PSIsInZhbHVlIjoiYkxQcjNpU3gxcjhDRnB==",
    *           "keyNumber": 4
    *       },
    *       "proofOfWorkDetails": {
    *           "fixedStrings": [
    *               "e90eba67bade315aa6535a",
    *               "8fb32a74dccc2ffb11918",
    *                "30a89cc70a1e17010c5bd"
    *           ],
    *           "difficulty": 2
    *       }
    *   }
    *}
    */
    public function generate(Request $request)
    {
        return new CaptchaResource(new Captcha());
    }

    public function verify(Request $request)
    {
        
    }
}
