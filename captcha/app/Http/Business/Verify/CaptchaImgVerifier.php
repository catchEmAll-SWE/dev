<?php

namespace App\Http\Business\Verify;

use App\Http\Business\Ecryption\AES256Cipher;

class CaptchaImgVerifier {
    //PRECONDITION: $user_response is a string of 10 digits, each digit is 0 or 1, key_number is an integer between 0 and 19
    public static function isCaptchaImgCorrect(string $user_response, string $encrypted_solution, int $key_number) : bool {
        $solution = self::getDecryptedSolution($encrypted_solution, $key_number);
        
        // 0 ==> unselected
        // 1 ==> selected
        // 2 ==> # of unselected > x

        $uncertain_images = 0;
        $uncertain_images_selected = 0;

        foreach(str_split($solution) as $index => $single_image_solution) {
            if ($single_image_solution == '0' && $user_response[$index] != '0') return false;
            if ($single_image_solution == '1' && $user_response[$index] != '1') return false;
            if ($single_image_solution == '2') {
                $uncertain_images++;
                if ($user_response[$index] == '0')
                    $uncertain_images_selected++; 
            }
        }
        // FIXME: 0.7 is a example number
        return ($uncertain_images_selected / $uncertain_images >= 0.7 ) ? true : false;
    }

    public static function getDecryptedSolution(string $solution, int $key_number) : string {
        $algorithm = new AES256Cipher();
        return $algorithm->decrypt($solution, $key_number);
    }
}