<?php

namespace App\Http\Resources\V1;

use App\Http\Business\ProofOfWorkDetails;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProofOfWorkDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'fixedStrings' => $this->getFixedString(),
            'difficulty' => $this->getDifficulty(),
        ];
    }
}
