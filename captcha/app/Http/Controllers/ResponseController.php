<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResponseController extends Controller
{
    public function manageResponse(Request $request) {
        dd($request->all());
        /*$http = new \GuzzleHttp\Client;
        $response = $http->post("http://localhost/SWE/dev/captcha/public/api/v1/verify",[
            'headers'=>['Authorization' => "Bearer 4|Ag86uaVLYDvQP306TAA0TXawe68LPTkTtVhN8cff"],
            'query' => [

            ]
        ]);*/
        return view('response');
    }
}
