<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\ProfileFloodExposure;
use App\Models\ProfileHealthCondition;
use App\Models\ProfileSector;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    // THIS IS TO GET DATA
    public function getProfiles(){
        $profiles = Profile::all();
        return response()->json($profiles);
    }

    // THIS IS TO STORE DATA
    public function addProfile(Request $request){
        $profiles = new Profile();
        $profiles->livelihood_status_id = $request->livelihood_status_id;
        $profiles->family_income_range_id = $request->family_income_range_id;
        $profiles->tenurial_status_id = $request->tenurial_status_id;
        $profiles->kayabe_kard_type_id = $request->kayabe_kard_type_id;
        $profiles->dependent_range_id = $request->dependent_range_id;
        $profiles->total_dependents = $request->total_dependents;
        $profiles->family_vulnerability = $request->family_vulnerability;
        $profiles->identity_card_no = $request->identity_card_no;
        $profiles->medication = $request->medication;
        $profiles->remarks = $request->remarks;
        $profiles->save();

       // Retrieve the last inserted Profile's ID
        $lastInsertedProfileId = $profiles->id;

        // accept multiple input for flood_exposure_id
        if ($request->has('flood_exposure_id')) {
            $floodExposureIds = $request->input('flood_exposure_id');
            foreach ($floodExposureIds as $floodExposureId) {
                $profileFloodExposure = new ProfileFloodExposure();
                $profileFloodExposure->profile_id = $lastInsertedProfileId;
                $profileFloodExposure->flood_exposure_id = $floodExposureId;
                $profileFloodExposure->save();
            }
        }
        
        // accept multiple input for health_condition_id
        if ($request->has('health_condition_id')) {
            $healthConditionIds = $request->input('health_condition_id');
            foreach ($healthConditionIds as $healthConditionId) {
                $profileHealthCondition = new ProfileHealthCondition();
                $profileHealthCondition->profile_id = $lastInsertedProfileId;
                $profileHealthCondition->health_condition_id = $healthConditionId;
                $profileHealthCondition->save();
            }
        }

        // accept multiple input for sector_id
        if ($request->has('sector_id')) {
            $sectorIds = $request->input('sector_id');
            foreach ($sectorIds as $sectorId) {
                $profileSector = new ProfileSector();
                $profileSector->profile_id = $lastInsertedProfileId;
                $profileSector->sector_id = $sectorId;
                $profileSector->save();
            }
        }

        return response()->json('Added Successfully');
    }
}
