<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
//THIS IS THE NEW IMPORT
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as FakerFactory;

class ProfilesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // // THIS IS FOR PROFILE AND CITIZEN
        $dummy = FakerFactory::create();
        for($i=0; $i<1000; $i++){
            // THIS IS FOR THE PROFILES
            $profileId = DB::table('profiles')->insertGetId([
                'livelihood_status_id' => $dummy->numberBetween(1, 2), // Replace 1 and 10 with your desired range
                'family_income_range_id' => $dummy->numberBetween(1, 2),
                'tenurial_status_id' => $dummy->numberBetween(1, 3),
                'kayabe_kard_type_id' => $dummy->numberBetween(1, 3),
                'dependent_range_id' => $dummy->numberBetween(1, 2),
                'total_dependents' => $dummy->numberBetween(1,5),
                'family_vulnerability' => $dummy->randomElement([0, 1]),
                'identity_card_no' => $dummy->randomNumber(),
                'medication' => $dummy->randomLetter(),
                'remarks' => $dummy->randomLetter(),
            ]);

            // THESE ARE THE DATA TO BE USE
            // Get the current year as a string
            $currentYear = date('Y');

            // Combine the profile ID and current year to create the 'pin'
            $pin = $currentYear . '-' . $profileId;

            // these are the barangays
            $barangayList = [
                'Alasas', 'Bulaon', 'Dela Paz Norte',
                'Dela Paz Sur', 'Del Carmen', 'Del Pilar',
                'Dolores', 'Juliana', 'Lara',
                'Lourdes', 'Magliman', 'Maimpis',
                'San Felipe', 'San Isidro', 'San Juan',
                'San Jose', 'San Pedro', 'San Nicolas',
                'Sindalan', 'Sta. Lucia', 'Sta. Teresita',
                'Sto. Nino', 'Sto. Rosario', 'Pandaras',
                'Baliti', 'Saguin', 'Del Rosario',
                'Panipuan', 'San Agustin', 'Calulut',
                'Malpitic', 'Pulung Bulu', 'Malino',
                'Quebiawan', 'Telebastagan'];

            // THIS IS FOR THE CITIZENS
            DB::table('citizens')->insert([
                'pin' => $pin,
                'pin_year' => $currentYear,
                'pin_series' => $profileId,
                'forename' => Str::upper($dummy->name),
                'midname' => Str::upper($dummy->lastName),
                'surname' => Str::upper($dummy->lastName),
                'suffix' => Str::upper($dummy->suffix),
                'birthdate' => $dummy->date($format = 'Y-m-d', $max = 'now'),
                'gender_id' => $dummy->numberBetween(1, 5),
                'vicinity' => Str::upper($dummy->address),
                'barangay' => Str::upper($dummy->randomElement($barangayList)),
                'profile_id' => $profileId,
                'avatar' => $dummy->imageUrl($width = 640, $height = 480) ,
                'info_status' => $dummy->randomElement(['COMPLETE', 'INCOMPLETE']),
                'created_at' => $dummy->dateTimeThisDecade($max = 'now', $timezone = null),
                'updated_at' => $dummy->dateTimeThisDecade($max = 'now', $timezone = null),
                'deleted_at' => $dummy->dateTimeThisDecade($max = 'now', $timezone = null),
            ]);

            // FOR FLOOD
            // get the value from the table
            $flood = DB::table('flood_exposures')->get();
            // select to one of the ids
            $randomFlood = $flood->random();
            // convert to int
            $randomFloodId = intval($randomFlood->id);
            for ($l = 1; $l <= $randomFloodId; $l++) {
                DB::table('profile_flood_exposure')->insert([
                    'profile_id' => $profileId,
                    'flood_exposure_id' => $l,
                ]);
            }

            // FOR HEALTH
            // get the value from the table
            $health = DB::table('health_conditions')->get();
            // select to one of the ids
            $randomHealth = $health->random();
            // convert to int
            $randomHealthId = intval($randomHealth->id);
            for ($k = 1; $k <= $randomHealthId; $k++) {
                DB::table('profile_health_condition')->insert([
                    'profile_id' => $profileId,
                    'health_condition_id' => $k,
                ]);
            }
            // FOR SECTOR
            // get the value from the table
            $sectors = DB::table('sectors')->get();
            // select to one of the ids
            $randomSector = $sectors->random();
            // convert to int
            $randomSectorId = intval($randomSector->id);
            for ($j = 1; $j <= $randomSectorId; $j++) {
                DB::table('profile_sector')->insert([
                    'profile_id' => $profileId,
                    'sector_id' => $j,
                ]);
            }
           
        }

    }
}
