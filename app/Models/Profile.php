<?php

namespace App\Models;

use App\Models\LivelihoodStatus;
use App\Models\FamilyIncomeRange;
use App\Models\TenurialStatus;
use App\Models\KayabeKardType;
use App\Models\DependentRange;
use App\Models\Citizen;
use App\Models\FloodExposure;
use App\Models\HealthCondition;
use App\Models\Sector;
use App\Models\Gender;
use Illuminate\Database\Eloquent\SoftDeletes;
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

    // profile has one livelihood status
    public function livelihood_statuses(){
        return $this->belongsTo(LivelihoodStatus::class, 'livelihood_status_id');
    }

    // profile has one family income range
    public function family_income_ranges(){
        return $this->belongsTo(FamilyIncomeRange::class, 'family_income_range_id');
    }

    // profile has one tenurial status
    public function tenurial_statuses(){
        return $this->belongsTo(TenurialStatus::class, 'tenurial_status_id');
    }

    // profile has one kayabe kard type
    public function kayabe_kard_types(){
        return $this->belongsTo(KayabeKardType::class, 'kayabe_kard_type_id');
    }

    // profile has one kayabe kard type
    public function dependent_ranges(){
        return $this->belongsTo(DependentRange::class, 'dependent_range_id');
    }
}
