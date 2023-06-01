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
        $response->assertRedirect('docs');
    }

    public function test_generate_captcha_route_return_json_with_right_values () : void {

        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $response = $this->get('api/v1/generate');

        $response->assertJson(fn (AssertableJson $json) =>
            $json->has('data', fn (AssertableJson $json) =>
                $json->where('captchaImg', fn (array $captchaImg) => count($captchaImg) == 10)
                    ->has('proofOfWorkDetails', fn (AssertableJson $json) =>
                        $json->has('fixedStrings')
                            ->has('difficulty')
                        )
                    )
        );
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
