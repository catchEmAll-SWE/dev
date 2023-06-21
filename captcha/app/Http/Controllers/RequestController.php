<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Http\Business\EncryptionService;
use App\Http\Business\Ecryption\AES256Cipher;

class RequestController extends Controller
{
    public function manageResponse(Request $request) {
        $selected_images_indexes = $request->input('image');
        $selected_images_indexes = ($selected_images_indexes == null) ? [] : $selected_images_indexes;
        $user_response = "";
        for($i = 0; $i<10; $i++){
            if(in_array($i, $selected_images_indexes)){
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
        $response = Http::withToken("4|Ag86uaVLYDvQP306TAA0TXawe68LPTkTtVhN8cff")->post("//https://swe.gdr00.it/api/v1/verify",[ 
                "response" => $user_response,
                "solution" => $solution,
                "keyNumber" => $key,
                "fixedStrings" => $fixed_strings,
                "nonces" => $nonces,
            ]);
        switch ($response->status()) {
            case 400:
                return redirect('docs');
            case 404:
                return redirect('/')->with('error', 'Captcha fallito ritenta');
            case 429:
                return redirect('docs');
            default:
            $service = new EncryptionService(new AES256Cipher());
            $response = json_decode($service->decrypt($response->body(), base64_decode("NJdmUbLdI6qZkDhqENZ2tA+zO48SksBEXAS5raDJ8VE=")),true);
            if($response["userClass"] == "bot")
                return redirect('/')->with('error', 'Captcha fallito ritenta');
            else if($response["userClass"] == "human")
                return view('human');
        }
    }

    public function manageGenerate(){
        $response = Http::withToken("4|Ag86uaVLYDvQP306TAA0TXawe68LPTkTtVhN8cff")->get("//https://swe.gdr00.it/api/v1/generate");
        return $response->json();
    }

}
