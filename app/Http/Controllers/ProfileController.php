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

        return response()->json($citizen_resource);
    }
    
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

            // Accept multiple input for flood_exposure_id, health_condition_id, and sector_id
            $floodExposureIds = $request->input('flood_exposure_id', []);
            $healthConditionIds = $request->input('health_condition_id', []);
            $sectorIds = $request->input('sector_id', []);

            // Attach related data to the profile using the sync method
            $profiles->floodExposures()->sync($floodExposureIds);
            $profiles->healthConditions()->sync($healthConditionIds);
            $profiles->sectors()->sync($sectorIds);

        }

        // Retrieve the last inserted Profile's ID
        $lastInsertedProfileId = $profiles->id;

        // to save the identity card no
        $profiles->identity_card_no = $lastInsertedProfileId;
        $profiles->save();

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
        // Update flood exposure with sync
        $floodExposureIds = $request->input('flood_exposure_id', []);
        $profile->floodExposures()->sync($floodExposureIds);

        // Update health condition with sync
        $healthConditionIds = $request->input('health_condition_id', []);
        $profile->healthConditions()->sync($healthConditionIds);

        // Update sector with sync
        $sectorIds = $request->input('sector_id', []);
        $profile->sectors()->sync($sectorIds);  

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

    // THIS IS TO SOFT DELETE CITIZEN, FOR NOW CITIZEN IS THE ONLY ONE BEING CALLED
    public function deleteCitizen($id){

        // Find the existing profile by ID
        $profile = Profile::find($id);

        if (!$profile) {
            return response()->json('Profile not found', 404);
        }

        // Update the citizen record if it exists
        $citizens = Citizen::where('profile_id', $id)->first();
        if ($citizens) {
            $citizens->delete();
        }

        return response()->json('Deleted Successfully');
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
