<?php

namespace App\Http\Business\Verify;

use App\Http\Business\EncryptionService;
use App\Http\Business\Ecryption\AES256Cipher;

enum UserClass: string
{
    case Human = 'human';
    case Bot = 'bot';
}

class CaptchaJsonResultGenerator
{
    private static $key = "NJdmUbLdI6qZkDhqENZ2tA+zO48SksBEXAS5raDJ8VE=";

    public static function createHumanResult(): string
    {
        $service = new EncryptionService(new AES256Cipher());
        return $service->encrypt(self::getJsonResponse(UserClass::Human), base64_decode(self::$key));
    }

    public static function createBotResult(): string
    {
        $service = new EncryptionService(new AES256Cipher());
        return $service->encrypt(self::getJsonResponse(UserClass::Bot), base64_decode(self::$key));
    }

    private static function getJsonResponse (UserClass $userClass) : string {
        return json_encode([
            'userClass' => $userClass,
            'time' => time()
        ]);
    }
}