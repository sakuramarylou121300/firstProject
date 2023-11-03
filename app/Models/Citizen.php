<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citizen extends Model
{
    use HasFactory;

    // all fillable
    protected $guarded = [];

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
