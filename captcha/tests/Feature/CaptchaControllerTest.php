<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Testing\Fluent\AssertableJson;

class CaptchaControllerTest extends TestCase
{
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
                $json->has('captchaImg', fn (AssertableJson $json) =>
                    $json->has('images', fn (AssertableJson $json) =>
                        $json->has(10)
                        ->etc()
                    )
                    ->has('solution')
                    ->has('keyNumber')
                )
                ->has('proofOfWorkDetails', fn (AssertableJson $json) =>
                    $json->has('fixedStrings')
                    ->has('difficulty')
                )
            )
        );
    }

    public function test_verify_captcha_without_token() : void{
        $response = $this->post('api/v1/verify');
        $response->assertRedirect('docs');
    }

    public function test_verify_using_request_with_missing_params () : void {

        $response = $this->post('api/v1/verify', [
            'random attribute' => 'random value'
        ]);

        $response->assertRedirect('docs');
    }

    public function test_verify_captcha_response() : void{

        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $response = $this->post('api/v1/verify', [
            'response' => '1111111111',
            'solution' => 'xsdhbcisdbciu',
            'keyNumber' => '4',
            'fixedStrings' => ['tryrtfqwertafdtyertsqw', 'tryrtfqwertafdtyertsqw', 'tryrtfqwertafdtyertsqw'],
            'nonces' => ['random nonce', 'random nonce', 'random nonce'],
        ]);

        $response->assertStatus(200);
    }
}
