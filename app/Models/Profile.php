<?php

namespace App\Models;

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
