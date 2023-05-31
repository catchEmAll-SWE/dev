<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Support\Facades\DB;

class CaptchaControllerTest extends TestCase
{
    /*
    Test generate:
        - Request unauthorized (401)
        - Request authorized (200), con json avente come attributi:
            - captchaImg
                - src 
                - solution
                - keyNumber
            - proofOfWorkDetails
                - fixedString
                - difficulty 
    */

    public function test_generate_captcha_route_without_token () : void {
        $response = $this->get('api/v1/generate');
        $response->assertStatus(401);
    }

    public function test_generate_captcha_route_return_json_with_right_values () : void {
        $user = DB::table('users')->select('*')->where('email', '=', 'catchemall@email.com')->first();
        Sanctum::actingAs($user, ['*']);
        $response = $this->get('api/v1/generate');
        //$response->assertStatus(200);

        $json_response = json_decode($response->getContent());

    }


    /*
    Test verify:
        - Request unauthorized (401)
        - Request authorized (200), con attributi:
            - user solution
            - solution
            - keyNumber
            - fixedString
            - difficulty
    */

    public function test_verify_captcha_without_token() : void{
        $response = $this->get('api/v1/verify');
        $response->assertStatus(401);
    }

    public function test_verify_captcha_response() : void{
    }
}
