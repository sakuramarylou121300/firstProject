<?php

namespace App\Models;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FloodExposure extends Model
{
    use HasFactory;

    // sectors belongs to many profile
    public function profiles(){
        return $this->belongsToMany(Profile::class);
    }
}
