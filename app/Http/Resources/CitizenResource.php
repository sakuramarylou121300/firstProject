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
            'profile_id' => [
                'id' => $this->profiles->id,
                'livelihood_status_id' => [
                    'id' => $this->profiles->livelihood_statuses->id,
                    'name' => $this->profiles->livelihood_statuses->name,
                ],
                'family_income_range_id' => [
                    'id' => $this->profiles->family_income_ranges->id,
                    'name' => $this->profiles->family_income_ranges->name,
                ],
                'tenurial_status_id' => [
                    'id' => $this->profiles->tenurial_statuses->id,
                    'name' => $this->profiles->tenurial_statuses->name,
                ],
                'kayabe_kard_type_id' => [
                    'id' => $this->profiles->kayabe_kard_types->id,
                    'name' => $this->profiles->kayabe_kard_types->name,
                ],
                'dependent_range_id' => [
                    'id' =>  $this->profiles->dependent_ranges->id,
                    'name' =>  $this->profiles->dependent_ranges->name,
                ],
            ],
            'profile_flood_exposure' => $this->profileFloodExposure->map(function ($item) {
                return [
                    'profile_id' => $item->profile_id,
                    'flood_exposure_id' => [
                        'id' => $item->floodExposures->id,
                        'name' => $item->floodExposures->name,
                    ],
                ];
            }),
            'profile_health_condition' => $this->profileHealthCondition->map(function ($item) {
                return [
                    'profile_id' => $item->profile_id,
                    'health_condition_id' => [
                        'id' => $item->healthConditions->id,
                        'name' => $item->healthConditions->name,
                    ],
                ];
            }),
            'profile_sector' => $this->profileSectors->map(function ($item) {
                return [
                    'profile_id' => $item->profile_id,
                    'sector_id' => [
                        'id' => $item->sectors->id,
                        'code' => $item->sectors->code,
                        'name' => $item->sectors->name,
                    ],
                ];
            }),

        ];
    }
}
