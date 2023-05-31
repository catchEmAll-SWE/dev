<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

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

    Test verify:
        - Request unauthorized (401)
        - Request authorized (200), con attributi:
            - user solution
            - solution
            - keyNumber
            - fixedString
            - difficulty
    */
}
