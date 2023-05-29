<?php

namespace App\Http\Business;

use App\Http\Business\Ecryption\AES256Cipher;
use App\Http\Business\Ecryption\IEncryptionAlgorithm;
use InvalidArgumentException;

class SolutionParser {

    public static function parseToEncryptedString(string $solution, array $target_class_images) : string {
        return (new AES256Cipher())->encrypt(json_encode(new CaptchaImgSolution($solution, $target_class_images)));
    }

    public static function parseFromEncryptedString(string $encrypted_data, int $key) : CaptchaImgSolution {
        $data = json_decode((new AES256Cipher())->decrypt($encrypted_data, $key));
        if ($data == null || (!isset($data->solution) || !isset($data->targetClassImagesId)))
            throw new InvalidArgumentException("Invalid encrypted solution passed");
        return new CaptchaImgSolution($data->solution, $data->targetClassImagesId);
    }

    // FIXME: create a static variable to store the encryption algorithm
}
