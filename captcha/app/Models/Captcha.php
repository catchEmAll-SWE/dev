<?php

namespace App\Models;

use App\Http\Business\Generate\CaptchaImgBuilder;
use App\Http\Business\Generate\ProofOfWorkDetails;
use Illuminate\Database\Eloquent\Model;

class Captcha extends Model {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'active_captchas';

    protected $fillable = ['id'];
    public $incrementing = false;
    public $timestamps = false;

    private CaptchaImg $captcha_img;
    private ProofOfWorkDetails $proof_of_work_details;

    public function getField($field){
        if ($field == 'id')
            return $this->captcha_img->getId();
        return 'null';
    }

    public function __construct()
    {
        $this->captcha_img = CaptchaImgBuilder::getGenerator()->getCaptchaImg();
        $this->proof_of_work_details = new ProofOfWorkDetails($this->captcha_img->getId());
    }

    public function getCaptchaImg() : CaptchaImg {
        return $this->captcha_img;
    }

    public function getProofOfWorkDetails() : ProofOfWorkDetails {
        return $this->proof_of_work_details;
    }
}