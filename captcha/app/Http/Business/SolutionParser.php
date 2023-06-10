<?php

namespace App\Http\Business;

use App\Http\Business\Ecryption\AES256Cipher;
use InvalidArgumentException;

class SolutionParser {

    public static function parseToEncryptedString(string $solution, array $target_class_images) : string {
        $service = new EncryptionService(new AES256Cipher());
        return $service->encryptWithActiveKey(json_encode(new CaptchaImgSolution($solution, $target_class_images)));
    }

    public static function parseFromEncryptedString(string $encrypted_data, int $key) : CaptchaImgSolution {
        $service = new EncryptionService(new AES256Cipher());
        $data = json_decode($service->decrypt($encrypted_data, $key));
        if ($data == null || (!isset($data->solution) || !isset($data->targetClassImagesId)))
            throw new InvalidArgumentException("Invalid encrypted solution passed");
        return new CaptchaImgSolution($data->solution, $data->targetClassImagesId);
    }
}
