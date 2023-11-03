<?php

namespace App\Models;

use App\Models\Profile;
use App\Models\ProfileFloodExposure;
use App\Models\ProfileHealthCondition;
use App\Models\ProfileSector;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citizen extends Model
{
    use HasFactory;

    // all fillable
    protected $guarded = [];

<<<<<<< HEAD
     // citizen belongs to profile
     public function profiles(){
=======
    // citizen belongs to profile
    public function profiles(){
>>>>>>> 73cdac67364c90cf836419a5a92cdc12351212f3
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
<<<<<<< HEAD
    return $this->hasMany(ProfileSector::class, 'profile_id'); 
=======
    return $this->hasMany(ProfileSector::class, 'profile_id');
>>>>>>> 73cdac67364c90cf836419a5a92cdc12351212f3
    }

}
