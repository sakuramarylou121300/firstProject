<?php

namespace App\Models;

use App\Models\Gender;
use App\Models\Profile;
use App\Models\ProfileFloodExposure;
use App\Models\ProfileHealthCondition;
use App\Models\ProfileSector;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citizen extends Model
{
    use HasFactory, SoftDeletes;

    // all fillable
    protected $guarded = [];

<<<<<<< HEAD
    // TO UPPER CASE
    protected $uppercaseFields = ['forename', 'midname', 'surname', 'vicinity', 'barangay', 'info_status'];
    
    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->uppercaseFields)) {
            $this->attributes[$key] = strtoupper($value);
        } else {
            parent::setAttribute($key, $value);
        }
    }

=======
>>>>>>> 622f352ab3370715678069aef31c980f3053a057
    public function genders(){
        return $this->belongsTo(Gender::class, 'gender_id');
    }

    // citizen belongs to profile
    public function profiles(){
        return $this->belongsTo(Profile::class, 'profile_id');
    }

    // citizen has many to flood exposure
    public function profileFloodExposure(){
        return $this->hasMany(ProfileFloodExposure::class, 'profile_id');
    }

    // citizen has many health condition
    public function profileHealthCondition(){
        return $this->hasMany(ProfileHealthCondition::class, 'profile_id');
    }

    // citizen has many health condition
    public function profileSectors(){
    return $this->hasMany(ProfileSector::class, 'profile_id');
    }

}