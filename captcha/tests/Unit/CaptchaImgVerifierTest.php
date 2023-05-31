<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class CaptchaImgVerifierTest extends TestCase
{
    /**
     * - se l'utente clicca honeypot => captcha non valido
     * - se l'utente non clicca un'immagine target ed affidabile => captcha non valido
     * - se l'utente clicca un'immagine non target ed affidabile => captcha non valido
     * - verificare che venga aggiornata affidabilità su immagini target
     * - test immagini non affidabili
     * 
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }
}
