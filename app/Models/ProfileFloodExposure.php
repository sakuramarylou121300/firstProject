<?php

namespace App\Models;

use App\Models\Profile;
use App\Models\FloodExposure;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileFloodExposure extends Model
{
    use HasFactory;
    
    protected $guarded = [];
    // disregard the updated_at and created_at
    public $timestamps = false;

    // emphasize the table name
    protected $table = 'profile_flood_exposure';

    // profile flood exposure belongs to table flood exposure
    public function floodExposures(){
        return $this->belongsTo(FloodExposure::class, 'flood_exposure_id');
    }



}