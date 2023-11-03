<?php

namespace App\Models;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthCondition extends Model
{
    use HasFactory;

<<<<<<< HEAD
=======
    protected $guarded = [];

>>>>>>> 73cdac67364c90cf836419a5a92cdc12351212f3
    // sectors belongs to many profile
    public function profiles(){
        return $this->belongsToMany(Profile::class);
    }
}
