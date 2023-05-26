<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CaptchaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'captchaImg' => new CaptchaImgResource($this->getCaptchaImg()),
            'proofOfWorkDetails' => new ProofOfWorkDetailsResource($this->getProofOfWorkDetails()),
        ];
    }
}
