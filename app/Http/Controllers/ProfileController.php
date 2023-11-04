<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\ProfileFloodExposure;
use App\Models\ProfileHealthCondition;
use App\Models\ProfileSector;
use App\Models\Citizen;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\CitizenResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ProfileController extends Controller
{
    // THIS IS TO GET DATA, testing only
    public function getProfiles(){
        $profiles = Profile::all();
        $profiles_resource = ProfileResource::collection($profiles);
        return response()->json($profiles_resource);
    }

    public function getOneCitizen($pin) {
        $citizen = Citizen::where('pin', $pin)->first();

        if (!$citizen) {
            return response()->json(['message' => 'Citizen not found.'], 404);
        }

        $citizen_resource = new CitizenResource($citizen);
        // $profileFloodExposure = $citizen->profileFloodExposure;

        return response()->json($citizen_resource);
    }

    // // get citizen by their pin
    // public function getOneCitizen($pin) {
    //     // get citizen first
    //     $citizen = Citizen::where('pin', $pin)->first();
        
    //     if (!$citizen) {
    //         return response()->json(['error' => 'Citizen not found'], 404);
    //     }
    
    //     // now the profile
    //     // Use the 'profile' relationship to retrieve the related Profile
    //     $profile = $citizen->profiles;
    
    //     if (!$profile) {
    //         return response()->json(['error' => 'Profile not found for this Citizen'], 404);
    //     }
    
    //     // get profileFloodExposure with profile_id, profileFloodExposure and citizen share the same profile_id
    //     $profileFloodExposure = $citizen->profileFloodExposure;

    //     if ($profileFloodExposure->isEmpty()) {
    //         return response()->json(['error' => 'No Flood Exposure records found for this Citizen'], 404);
    //     }

    //     // get profileHealthCondition with profile_id, profileHealthCondition and citizen share the same profile_id
    //     $profileHealthCondition = $citizen->profileHealthCondition;

    //     if ($profileHealthCondition->isEmpty()) {
    //         return response()->json(['error' => 'No Health Condition records found for this Citizen'], 404);
    //     }

    //     // get profileHealthCondition with profile_id, profileHealthCondition and citizen share the same profile_id
    //     $profileSector = $citizen->profileSectors;

    //     if ($profileSector->isEmpty()) {
    //         return response()->json(['error' => 'No Sector records found for this Citizen'], 404);
    //     }
    //     if ($profileSector) {
    //         return response()->json([
    //             'citizen' => $citizen,
    //         ]);
    //     } else {
    //         return response()->json(['error' => 'ProfileFloodExposure not found for this Profile'], 404);
    //     }
    // }
    
    // THIS IS TO STORE DATA
    public function addCitizen(Request $request){

        // Call the validation function
         $validator = $this->validateProfileData($request);

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

    // THIS IS TO UPDATE DATA
    public function updateCitizen(Request $request, $id){

        // Call the validation function
        $validator = $this->validateProfileData($request);
        if($validator->fails()){
            return $validator->errors();
        }else{
            // Find the existing profile by ID
            $profile = Profile::find($id);

            if (!$profile) {
                return response()->json('Profile not found', 404);
            }

            // Update the existing profile with the new data
            $profile->livelihood_status_id = $request->livelihood_status_id;
            $profile->family_income_range_id = $request->family_income_range_id;
            $profile->tenurial_status_id = $request->tenurial_status_id;
            $profile->kayabe_kard_type_id = $request->kayabe_kard_type_id;
            $profile->dependent_range_id = $request->dependent_range_id;
            $profile->total_dependents = $request->total_dependents;
            $profile->family_vulnerability = $request->family_vulnerability;
            $profile->medication = $request->medication;
            $profile->remarks = $request->remarks;
            $profile->save();
        }

        // update flood exposure with attach
        if ($request->has('flood_exposure_id')) {
            $floodExposureIds = $request->input('flood_exposure_id');
        
            // Find the existing profile by ID
            $profiles = Profile::find($id);
        
            if (!$profiles) {
                return response()->json('Profile not found', 404);
            }
        
            // Use the sync method to update the flood exposures for the profile
            $profiles->floodExposures()->sync($floodExposureIds);
        } 
        // update health condition with attach
        if ($request->has('health_condition_id')) {
            $healthConditionIds = $request->input('health_condition_id');
        
            // Find the existing profile by ID
            $profiles = Profile::find($id);
        
            if (!$profiles) {
                return response()->json('Profile not found', 404);
            }
        
            // Use the sync method to update the flood exposures for the profile
            $profiles->healthConditions()->sync($healthConditionIds);
        }   
        // update sector with attach
        if ($request->has('sector_id')) {
            $sectorIds = $request->input('sector_id');
        
            // Find the existing profile by ID
            $profiles = Profile::find($id);
        
            if (!$profiles) {
                return response()->json('Profile not found', 404);
            }
        
            // Use the sync method to update the flood exposures for the profile
            $profiles->sectors()->sync($sectorIds);
        }   

        // Update the citizen record if it exists
        $citizens = Citizen::where('profile_id', $id)->first();
        if ($citizens) {
            // pin, pin_year, pin_series, and profile_id are excluded
            $citizens->forename = $request->forename;
            $citizens->midname = $request->midname;
            $citizens->surname = $request->surname;
            $citizens->suffix = optional($request)->input('suffix');
            $citizens->birthdate = $request->birthdate;
            $citizens->gender_id = $request->gender_id;
            $citizens->vicinity = $request->vicinity;
            $citizens->barangay	 = $request->barangay;
            $citizens->avatar = $request->avatar;
            $citizens->info_status = $request->info_status;
            $citizens->save();
        }

        return response()->json('Updated Successfully');
    }

    // FOR VALIDATION POST AND UPDATE
    private function validateProfileData(Request $request){
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
        
        return Validator::make($request->all(), $rules);
    }
}
