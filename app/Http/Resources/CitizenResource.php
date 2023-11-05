<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CitizenResource extends JsonResource
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
            'pin'=>$this->pin,
            'pin_year'=>$this->pin_year,
            'pin_series'=>$this->pin_series,
            'forename'=>$this->forename,
            'midname'=>$this->midname,
            'surname'=>$this->surname,
            'suffix'=>$this->suffix,
            'birthdate'=>$this->birthdate,
            'gender_id' =>$this->genders->toArray(),
            'vicinity'=>$this->vicinity,
            'barangay'=>$this->barangay,
            'profile_id' => [
                'id' => $this->profiles->id,
                // 'livelihood_status_id' => [
                //     'id' => $this->profiles->livelihood_statuses->id,
                //     'name' => $this->profiles->livelihood_statuses->name,
                // ],
                'livelihood_status_id' => $this->profiles->livelihood_statuses->toArray(),
                'family_income_range_id' => $this->profiles->family_income_ranges->toArray(),
                'tenurial_status_id' => $this->profiles->tenurial_statuses->toArray(),
                'kayabe_kard_type_id' => $this->profiles->kayabe_kard_types->toArray(),
                'dependent_range_id' => $this->profiles->dependent_ranges->toArray(),
            ],
            'avatar'=>$this->avatar,
            'info_status'=>$this->info_status,
            'profile_flood_exposure' => $this->profileFloodExposure->map(function ($item) {
                return [
                    'profile_id' => $item->profile_id,
                    'flood_exposure_id' => $item->floodExposures->toArray(),
                    // 'flood_exposure_id' => [
                    //     'id' => $item->floodExposures->id,
                    //     'name' => $item->floodExposures->name,
                    // ],
                ];
            }),
            'profile_health_condition' => $this->profileHealthCondition->map(function ($item) {
                return [
                    'profile_id' => $item->profile_id,
                    'health_condition_id' => $item->healthConditions->toArray(),
                ];
            }),
            'profile_sector' => $this->profileSectors->map(function ($item) {
                return [
                    'profile_id' => $item->profile_id,
                    'sector_id' => $item->sectors->toArray(),
                ];
            }),

        ];
    }
}
