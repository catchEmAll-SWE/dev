<?php

namespace App\Models;

use App\Http\Business\Generate\CaptchaImgBuilder;
use App\Http\Business\Generate\ProofOfWorkDetails;
use Illuminate\Database\Eloquent\Model;

class Captcha extends Model {

    protected $table = 'active_captchas';
    protected $primaryKey = 'hashed_id';

    protected $fillable = ['hashed_id'];
    public $incrementing = false;


    private CaptchaImg $captcha_img;
    private ProofOfWorkDetails $proof_of_work_details;

    public function __construct()
    {
        $this->captcha_img = CaptchaImgBuilder::getGenerator()->getCaptchaImg();
        $this->proof_of_work_details = new ProofOfWorkDetails($this->captcha_img->getId());
        $this->setAttribute('hashed_id', $this->captcha_img->getId());
    }

    public function getField (string $field) : string {
        return $this->{$field};
    }

    public function getId () : string {
        return $this->captcha_img->getId();
    }

    public function getCaptchaImg() : CaptchaImg {
        return $this->captcha_img;
    }

    public function getProofOfWorkDetails() : ProofOfWorkDetails {
        return $this->proof_of_work_details;
    }
}