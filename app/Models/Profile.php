<?php

namespace App\Models;

<<<<<<< HEAD
use App\Models\Citizen;
=======
>>>>>>> 73cdac67364c90cf836419a5a92cdc12351212f3
use App\Models\FloodExposure;
use App\Models\HealthCondition;
use App\Models\Sector;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model{
    use HasFactory;

    // all fillable
    protected $guarded = [];
    // disregard the updated_at and created_at
    public $timestamps = false;
    
    // profile has one citizen
    public function citizens(){
        return $this->hasOne(Citizen::class, 'profile_id');
    }

    // profiles belongs to many health condition
    public function floodExposures(){
        return $this->belongsToMany(FloodExposure::class, 'profile_flood_exposure');
    }

    // profiles belongs to many health condition
    public function healthConditions(){
        return $this->belongsToMany(HealthCondition::class, 'profile_health_condition');
    }

    // profiles belongs to many sector
    public function sectors(){
        return $this->belongsToMany(Sector::class);
    }

    // profiles belongs to many health condition
    public function floodExposures(){
        return $this->belongsToMany(FloodExposure::class, 'profile_flood_exposure');
    }

    // profiles belongs to many health condition
     public function healthConditions(){
        return $this->belongsToMany(HealthCondition::class, 'profile_health_condition');
    }

    // profiles belongs to many sector
    public function sectors(){
        return $this->belongsToMany(Sector::class);
    }

}
