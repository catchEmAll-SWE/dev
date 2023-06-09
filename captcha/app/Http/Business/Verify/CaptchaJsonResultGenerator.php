<?php

namespace App\Http\Business\Verify;

enum UserClass: string
{
    case Human = 'human';
    case Bot = 'bot';
}

class CaptchaJsonResultGenerator
{
    public static function createHumanResult(): string
    {
        return self::getJsonResponse(UserClass::Human);
    }

    public static function createBotResult(): string
    {
        return self::getJsonResponse(UserClass::Bot);
    }

    private static function getJsonResponse (UserClass $userClass) : string {
        return json_encode([
            'userClass' => $userClass,
            'time' => time()
        ]);
    }
}