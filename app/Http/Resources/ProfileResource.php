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
            'livelihood_status_id'=>$this->livelihood_statuses,
            'family_income_range'=>$this->family_income_ranges,
            'tenurial_status_id'=>$this->tenurial_statuses,
            'kayabe_kard_type_id'=>$this->kayabe_kard_types,
            'dependent_range_id'=>$this->dependent_ranges,
            'citizens'=>$this->citizens,
            'floodExposures'=>$this->floodExposures,
            'healthConditions'=>$this->healthConditions,
            'sectors'=>$this->sectors,
        ];
    }
}
