<?php

namespace Tests\Unit;

use App\Http\Business\Verify\CaptchaImgVerifier;
use Tests\TestCase;

class CaptchaImgVerifierTest extends TestCase
{
    /**
     * - se l'utente clicca honeypot => captcha non valido
     * - se l'utente non clicca un'immagine target ed affidabile => captcha non valido
     * - se l'utente clicca un'immagine non target ed affidabile => captcha non valido
     * - verificare che venga aggiornata affidabilità su immagini target -> da capire se serve (viene chiamato il metodo updateReliability che è già testato)
     * - test immagini non affidabili (da chiedere una cosa)
     * 
     */
    protected CaptchaImgVerifier $captcha_img_verifier_honeypot;
    protected CaptchaImgVerifier $captcha_img_verifier_target_not_clicked;
    protected CaptchaImgVerifier $captcha_img_verifier_not_target_clicked;
    protected CaptchaImgVerifier $captcha_img_verifier_unreliable_imgs_true;
    protected CaptchaImgVerifier $captcha_img_verifier_unreliable_imgs_false;
    protected CaptchaImgVerifier $captcha_img_verifier_correct_solution;

    protected function setUp() : void {
        parent::setUp();
        $this->captcha_img_verifier_honeypot = new CaptchaImgVerifier("eyJpdiI6Ik5KV2o2WWh6eCtyU1lWR0dwRjZCbWc9PSIsInZhbHVlIjoiNE9JaVpNNTVQUG0rT001U
        GpVZy9aRHU2dUtSMlJLL2p2N091c00wVkFubHhRY0Uvc3dmRDIwSWZqQzY4MkNxek5WNWZzS0RlTFVQSHNPMzJ1QXJiTXdYSmJOZFBGbUtha3NNeEdmbUFSTmIxTkMxUjMw
        bHl0K05yNHpSZC9KREUiLCJtYWMiOiI0NzlmOTdhYjU2YTY2OTcxMjU4NzgxNGU5NjI5ZGM5NjIzZmQzZmFjODZmZmEzZjVkODliNWM5MmQyODVmZjQ2IiwidGFnIjoiIn0=","0000101001",4);

        $this->captcha_img_verifier_target_not_clicked = new CaptchaImgVerifier("eyJpdiI6Ik5KV2o2WWh6eCtyU1lWR0dwRjZCbWc9PSIsInZhbHVlIjoiNE9JaVpNNTVQUG0rT001U
        GpVZy9aRHU2dUtSMlJLL2p2N091c00wVkFubHhRY0Uvc3dmRDIwSWZqQzY4MkNxek5WNWZzS0RlTFVQSHNPMzJ1QXJiTXdYSmJOZFBGbUtha3NNeEdmbUFSTmIxTkMxUjMw
        bHl0K05yNHpSZC9KREUiLCJtYWMiOiI0NzlmOTdhYjU2YTY2OTcxMjU4NzgxNGU5NjI5ZGM5NjIzZmQzZmFjODZmZmEzZjVkODliNWM5MmQyODVmZjQ2IiwidGFnIjoiIn0=","0000001000",4);

        $this->captcha_img_verifier_not_target_clicked = new CaptchaImgVerifier("eyJpdiI6Ik5KV2o2WWh6eCtyU1lWR0dwRjZCbWc9PSIsInZhbHVlIjoiNE9JaVpNNTVQUG0rT001U
        GpVZy9aRHU2dUtSMlJLL2p2N091c00wVkFubHhRY0Uvc3dmRDIwSWZqQzY4MkNxek5WNWZzS0RlTFVQSHNPMzJ1QXJiTXdYSmJOZFBGbUtha3NNeEdmbUFSTmIxTkMxUjMw
        bHl0K05yNHpSZC9KREUiLCJtYWMiOiI0NzlmOTdhYjU2YTY2OTcxMjU4NzgxNGU5NjI5ZGM5NjIzZmQzZmFjODZmZmEzZjVkODliNWM5MmQyODVmZjQ2IiwidGFnIjoiIn0=","0001101000",4);

        $this->captcha_img_verifier_unreliable_imgs_true = new CaptchaImgVerifier("eyJpdiI6Ik5KV2o2WWh6eCtyU1lWR0dwRjZCbWc9PSIsInZhbHVlIjoiNE9JaVpNNTVQUG0rT001U
        GpVZy9aRHU2dUtSMlJLL2p2N091c00wVkFubHhRY0Uvc3dmRDIwSWZqQzY4MkNxek5WNWZzS0RlTFVQSHNPMzJ1QXJiTXdYSmJOZFBGbUtha3NNeEdmbUFSTmIxTkMxUjMw
        bHl0K05yNHpSZC9KREUiLCJtYWMiOiI0NzlmOTdhYjU2YTY2OTcxMjU4NzgxNGU5NjI5ZGM5NjIzZmQzZmFjODZmZmEzZjVkODliNWM5MmQyODVmZjQ2IiwidGFnIjoiIn0=","1000101010",4);

        $this->captcha_img_verifier_unreliable_imgs_false = new CaptchaImgVerifier("eyJpdiI6Ik5KV2o2WWh6eCtyU1lWR0dwRjZCbWc9PSIsInZhbHVlIjoiNE9JaVpNNTVQUG0rT001U
        GpVZy9aRHU2dUtSMlJLL2p2N091c00wVkFubHhRY0Uvc3dmRDIwSWZqQzY4MkNxek5WNWZzS0RlTFVQSHNPMzJ1QXJiTXdYSmJOZFBGbUtha3NNeEdmbUFSTmIxTkMxUjMw
        bHl0K05yNHpSZC9KREUiLCJtYWMiOiI0NzlmOTdhYjU2YTY2OTcxMjU4NzgxNGU5NjI5ZGM5NjIzZmQzZmFjODZmZmEzZjVkODliNWM5MmQyODVmZjQ2IiwidGFnIjoiIn0=","1000101110",4);

        $this->captcha_img_verifier_correct_solution = new CaptchaImgVerifier("eyJpdiI6Ik5KV2o2WWh6eCtyU1lWR0dwRjZCbWc9PSIsInZhbHVlIjoiNE9JaVpNNTVQUG0rT001U
        GpVZy9aRHU2dUtSMlJLL2p2N091c00wVkFubHhRY0Uvc3dmRDIwSWZqQzY4MkNxek5WNWZzS0RlTFVQSHNPMzJ1QXJiTXdYSmJOZFBGbUtha3NNeEdmbUFSTmIxTkMxUjMw
        bHl0K05yNHpSZC9KREUiLCJtYWMiOiI0NzlmOTdhYjU2YTY2OTcxMjU4NzgxNGU5NjI5ZGM5NjIzZmQzZmFjODZmZmEzZjVkODliNWM5MmQyODVmZjQ2IiwidGFnIjoiIn0=","0000101000",4);

    }
    //233312122
    public function test_verify_correct_solution(){
        $this->assertTrue($this->captcha_img_verifier_correct_solution->verify());
    }

    public function test_verify_honeypot_false(){
        $this->assertFalse($this->captcha_img_verifier_honeypot->verify());
    }

    public function test_verify_target(){
        $this->assertFalse($this->captcha_img_verifier_target_not_clicked->verify());
    }

    public function test_verify_not_target(){
        $this->assertFalse($this->captcha_img_verifier_not_target_clicked->verify());
    }

    public function test_verify_unreliable_images(){
        $this->assertTrue($this->captcha_img_verifier_unreliable_imgs_true->verify());
        $this->assertFalse($this->captcha_img_verifier_unreliable_imgs_false->verify());
    }
}
