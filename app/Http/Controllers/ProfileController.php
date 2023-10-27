<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\ProfileFloodExposure;
use App\Models\ProfileHealthCondition;
use App\Models\ProfileSector;
use App\Models\Citizen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ProfileController extends Controller
{
    // THIS IS TO GET DATA
    public function getProfiles(){
        $profiles = Profile::all();
        return response()->json($profiles);
    }

    // THIS IS TO STORE DATA
    public function addProfile(Request $request){

        // validation
        $rules = array(
            'livelihood_status_id' => 'required|numeric|exists:livelihood_statuses,id',
            'family_income_range_id' => 'required|numeric|exists:family_income_ranges,id',
            'tenurial_status_id' => 'required|numeric|exists:livelihood_statuses,id',
            'kayabe_kard_type_id' => 'required|numeric|exists:kayabe_kard_types,id',
            'dependent_range_id' => 'required|numeric|exists:dependent_ranges,id',
            'total_dependents' => 'required|numeric|min:1',
            'family_vulnerability' => 'required|in:0,1',
            'medication' => 'required',
            'remarks' => 'required',
            'flood_exposure_id' => 'required|exists:flood_exposures,id',
            'health_condition_id' => 'required|exists:health_conditions,id',
            'sector_id' => 'required|exists:sectors,id',
            'forename' => 'required',
            'surname' => 'required',
            'birthdate' => 'required',
            'gender_id' => 'required|exists:genders,id',
            'vicinity' => 'required',
            'barangay' => 'required',
            'avatar' => 'required',
            'info_status' => 'required',
        );
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return $validator->errors();
        }else{
            $profiles = new Profile();
            $profiles->livelihood_status_id = $request->livelihood_status_id;
            $profiles->family_income_range_id = $request->family_income_range_id;
            $profiles->tenurial_status_id = $request->tenurial_status_id;
            $profiles->kayabe_kard_type_id = $request->kayabe_kard_type_id;
            $profiles->dependent_range_id = $request->dependent_range_id;
            $profiles->total_dependents = $request->total_dependents;
            $profiles->family_vulnerability = $request->family_vulnerability;
            $profiles->medication = $request->medication;
            $profiles->remarks = $request->remarks;
            $profiles->save();

        }

        // Retrieve the last inserted Profile's ID
        $lastInsertedProfileId = $profiles->id;

        // to save the identity card no
        $profiles->identity_card_no = $lastInsertedProfileId;
        $profiles->save();

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

        // this is to store citizen
        // Get the current year as a string
        $currentYear = date('Y');

        // Combine the profile ID and current year to create the 'pin'
        $pin = $currentYear . '-' . $lastInsertedProfileId;

        $citizens = new Citizen();
        $citizens->pin = $pin;
        $citizens->pin_year = $currentYear;
        $citizens->pin_series = $lastInsertedProfileId;
        $citizens->forename = $request->forename;
        $citizens->midname = $request->midname;
        $citizens->surname = $request->surname;
        $citizens->suffix = optional($request)->input('suffix');
        $citizens->birthdate = $request->birthdate;
        $citizens->gender_id = $request->gender_id;
        $citizens->vicinity = $request->vicinity;
        $citizens->barangay	 = $request->barangay;
        $citizens->profile_id = $lastInsertedProfileId;
        $citizens->avatar = $request->avatar;
        $citizens->info_status = $request->info_status;
        $citizens->save();

        return response()->json('Added Successfully');
    }
}
