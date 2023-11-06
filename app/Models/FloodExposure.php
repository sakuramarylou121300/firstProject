<?php

namespace App\Models;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FloodExposure extends Model
{
    use HasFactory;

<<<<<<< HEAD
     // sectors belongs to many profile
     public function profiles(){
=======
    // all fillable
    protected $guarded = [];

    // sectors belongs to many profile
    public function profiles(){
>>>>>>> 73cdac67364c90cf836419a5a92cdc12351212f3
        return $this->belongsToMany(Profile::class);
    }
}
