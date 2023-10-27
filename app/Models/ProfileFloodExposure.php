<?php

namespace App\Models;

use App\Models\Profile;
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

}