<?php

namespace App\Http\Business\Verify;

use App\Http\Business\ImageService;
use App\Http\Business\SolutionParser;

class CaptchaImgVerifier {
    private static float $reliability_delta = 0.3;
    private string $solution;
    private array $target_class_images;
    private string $user_answer;
    private ImageService $service;

    public function __construct(string $encrypted_solution, string $user_answer, int $key_number) 
    {
        $captcha_img_solution = SolutionParser::parseFromEncryptedString($encrypted_solution, $key_number);
        $this->solution = $captcha_img_solution->getSolution();
        $this->target_class_images = $captcha_img_solution->getTargetClassImages();
        $this->user_answer = $user_answer;
        $this->service = new ImageService();
    }

    //PRECONDITION: $user_response is a string of 10 digits, each digit is 0 or 1, key_number is an integer between 0 and 19 and target_class_images is an array of 10 strings
    public function verify() : bool {

        $uncertain_target_images = 0;
        $uncertain_target_images_selected = 0;

        $uncertain_images = 0;
        $uncertain_images_selected = 0;

        $target_img_counter = 0;

        $honey_pot = substr($this->user_answer, -1);
        if($honey_pot == '1')
            return false;

        $this->user_answer = substr($this->user_answer, 0, -1);

        foreach(str_split($this->solution) as $index => $single_image_solution) {

            // image target but uncertain
            if ($single_image_solution == '0'){
                $uncertain_target_images++;
                if ($this->user_answer[$index] == '1'){
                    $this->service->updateImageReliability($this->target_class_images[$target_img_counter], self::$reliability_delta);
                    $uncertain_target_images_selected++;
                }
                else
                    $this->service->updateImageReliability($this->target_class_images[$target_img_counter], self::$reliability_delta * -1);
                $target_img_counter++;
            }

            // image target and certain
            else if ($single_image_solution == '1'){
                if ($this->user_answer[$index] == '0'){
                    $this->service->updateImageReliability($this->target_class_images[$target_img_counter], self::$reliability_delta * -1);    
                    return false;
                }
                $this->service->updateImageReliability($this->target_class_images[$target_img_counter], self::$reliability_delta);

                $target_img_counter++;
            }

            // image non target and uncertain
            else if ($single_image_solution == '2'){
                $uncertain_images++;
                if ($this->user_answer[$index] == '1')
                    $uncertain_images_selected++;
            }

            //image non target and certain and selected
            else if ($single_image_solution == '3' && $this->user_answer[$index] == '1')
                return false;
                
        }

        $target_factor = ($uncertain_target_images != 0) ? $uncertain_target_images_selected / $uncertain_target_images : 1;
        $non_target_factor = ($uncertain_target_images_selected != 0) ? $uncertain_images_selected / $uncertain_images : 0;

        return $target_factor > 0.8 && $non_target_factor < 0.4;
    }

}
