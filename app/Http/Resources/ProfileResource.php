<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'livelihood_status_id'=>$this->id,
            'citizens'=>$this->citizens,
            'floodExposures'=>$this->floodExposures,
            'healthConditions'=>$this->healthConditions,
            'sectors'=>$this->sectors,
        ];
    }
}
