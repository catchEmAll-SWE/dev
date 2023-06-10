<?php

namespace Tests\Unit;

use App\Models\Captcha;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Support\Facades\DB;

class CaptchaControllerTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        if (Captcha::find('75c663c79321fab919ec39e285c8e4bee7088be195e98386266f84a83e8e1fb0') == null)
            DB::table('active_captchas')->insert(['hashed_id'=>'75c663c79321fab919ec39e285c8e4bee7088be195e98386266f84a83e8e1fb0']);
    }

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
                    ->has('target')
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

    public function test_verify_correct_captcha() : void{
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $response = $this->post('api/v1/verify', [
            'response' => '0001100100',
            'solution' => 'eyJpdiI6IkV3NllkdGpwcHNiMWNpRjJoSEVpSUE9PSIsInZhbHVlIjoiRG5ST3JDSkNlL1hLYWpqaE4vNUY5RVQ5VFh6NmdPdW9EYWtWUVJUYVB4RGlneFgyWlBsbDVzVGsrT0pOZzdjWUs2cXpHN1Vjcjd3NnJHUjloVDNaZFhQZGxWRWgyLzRsM1pvS1lRckpmeTVwQ3JVb1cweVpOOFVsVkROOXZ0VUh3OVhIMGNXSDNqZ1pxT2ZvdHBPMkhnPT0iLCJtYWMiOiI1ZjU4ZmUwZDU5MzQ0YjExODQyYWE1ZTE2MTBhNjQ5OWRkNzc4NjdmZThmMWJkZTU5NWVmZDIyNjc5MjExZjYzIiwidGFnIjoiIn0=',
            'keyNumber' => '4',
            'fixedStrings' => [
                "75c663c79321fab919ec39",
                "e285c8e4bee7088be195e",
                "98386266f84a83e8e1fb0"
            ],
            'nonces' => ['335', '258', '3'],
        ]);

        $response->assertStatus(200);
    }

    public function test_verify_wrong_captcha() : void{
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $response = $this->post('api/v1/verify', [
            'response' => '0001100100',
            'solution' => 'eyJpdiI6IkV3NllkdGpwcHNiMWNpRjJoSEVpSUE9PSIsInZhbHVlIjoiRG5ST3JDSkNlL1hLYWpqaE4vNUY5RVQ5VFh6NmdPdW9EYWtWUVJUYVB4RGlneFgyWlBsbDVzVGsrT0pOZzdjWUs2cXpHN1Vjcjd3NnJHUjloVDNaZFhQZGxWRWgyLzRsM1pvS1lRckpmeTVwQ3JVb1cweVpOOFVsVkROOXZ0VUh3OVhIMGNXSDNqZ1pxT2ZvdHBPMkhnPT0iLCJtYWMiOiI1ZjU4ZmUwZDU5MzQ0YjExODQyYWE1ZTE2MTBhNjQ5OWRkNzc4NjdmZThmMWJkZTU5NWVmZDIyNjc5MjExZjYzIiwidGFnIjoiIn0=',
            'keyNumber' => '4',
            'fixedStrings' => [
                "75c663c79321fab919ec39",
                "e285c8e4bee7088be195e",
                "000000000000000000000"
            ],
            'nonces' => ['335', '258', '143'],
        ]);

        $response->assertStatus(404);
    }
}