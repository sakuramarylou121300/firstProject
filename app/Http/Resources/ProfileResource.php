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
            'citizens' => [
                'id' => $this->citizens->id,
                'pin'=>$this->citizens->pin,
                'pin_year'=>$this->citizens->pin_year,
                'pin_series'=>$this->citizens->pin_series,
                'forename'=>$this->citizens->forename,
                'midname'=>$this->citizens->midname,
                'surname'=>$this->citizens->surname,
                'suffix'=>$this->citizens->suffix,
                'birthdate'=>$this->citizens->birthdate,
                'gender_id' =>$this->citizens->genders->toArray(),
                'vicinity'=>$this->citizens->vicinity,
                'barangay'=>$this->citizens->barangay,
                'profile_id' => [
                    'id' => $this->id,
                ],
            'avatar'=>$this->citizens->avatar,
            'info_status'=>$this->citizens->info_status,
            ],
            'floodExposures'=>$this->floodExposures,
            'healthConditions'=>$this->healthConditions,
            'sectors'=>$this->sectors,
        ];
    }
}