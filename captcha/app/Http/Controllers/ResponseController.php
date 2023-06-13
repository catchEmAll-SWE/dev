<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Business\EncryptionService;
use App\Http\Business\Ecryption\AES256Cipher;

class ResponseController extends Controller
{
    public function manageResponse(Request $request) {
        $response = $request->input('image');
        $user_response = "";
        for($i = 0; $i<10; $i++){
            if(in_array($i, $response)){
                $user_response .= "1";
            }else{
                $user_response .= "0";
            }
        }
        $solution = $request->input('solution');
        $key = intval($request->input('key'));
        $fixed_strings = explode(",",$request->input('fixedStrings'));
        $nonces = explode(",",$request->input('nonces'));
        $response = Http::withToken("4|Ag86uaVLYDvQP306TAA0TXawe68LPTkTtVhN8cff")->post("http://localhost/SWE/dev/captcha/public/api/v1/verify",[ 
                "response" => $user_response,
                "solution" => $solution,
                "keyNumber" => $key,
                "fixedStrings" => $fixed_strings,
                "nonces" => $nonces,
            ]);
        $service = new EncryptionService(new AES256Cipher());
        $response = json_decode($service->decrypt($response->body(), base64_decode("NJdmUbLdI6qZkDhqENZ2tA+zO48SksBEXAS5raDJ8VE=")),true);
        if($response["userClass"] == "bot"){
            return view('bot');
        }else if($response["userClass"] == "human")
            return view('human');
    }
}