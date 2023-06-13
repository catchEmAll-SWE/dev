<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Business\EncryptionService;
use App\Http\Business\Ecryption\AES256Cipher;

class RequestController extends Controller
{
    public function manageResponse(Request $request) {
        $response = $request->input('image');
        $response = ($response == null) ? [] : $response;
        $user_response = "";
        for($i = 0; $i<10; $i++){
            if($response && in_array($i, $response)){
                $user_response .= "1";
            }else{
                $user_response .= "0";
            }
        }
        $solution = $request->input('solution');
        $key = intval($request->input('key'));
        $fixed_strings = explode(",",$request->input('fixedStrings'));
        $nonces = explode(",",$request->input('nonces'));
        //http://localhost/SWE/dev/captcha/public/api/v1/verify
        //https://swe.gdr00.it/api/v1/verify
        $response = Http::withToken("4|Ag86uaVLYDvQP306TAA0TXawe68LPTkTtVhN8cff")->post("https://swe.gdr00.it/api/v1/verify",[ 
                "response" => $user_response,
                "solution" => $solution,
                "keyNumber" => $key,
                "fixedStrings" => $fixed_strings,
                "nonces" => $nonces,
            ]);
        if($response->status()==400)
            return redirect('docs');
        elseif($response->status()==404)
            return view('login', ["error" => "Captcha fallito, ritenta!"]);
        $service = new EncryptionService(new AES256Cipher());
        $response = json_decode($service->decrypt($response->body(), base64_decode("NJdmUbLdI6qZkDhqENZ2tA+zO48SksBEXAS5raDJ8VE=")),true);
        if($response["userClass"] == "bot"){
            return view('login');
        }else if($response["userClass"] == "human")
            return view('human');
    }

    public function manageGenerate(){
        $response = Http::withToken("4|Ag86uaVLYDvQP306TAA0TXawe68LPTkTtVhN8cff")->get("http://localhost/SWE/dev/captcha/public/api/v1/generate");
        return $response->json();
    }

}
