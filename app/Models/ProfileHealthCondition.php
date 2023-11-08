<?php

namespace App\Models;

use App\Models\HealthCondition;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileHealthCondition extends Model
{
    use HasFactory;

    protected $guarded = [];
    // disregard the updated_at and created_at
    public $timestamps = false;

    // emphasize the table name
    protected $table = 'profile_health_condition';

    // profile flood exposure belongs to table flood exposure
    public function healthConditions(){
        return $this->belongsTo(HealthCondition::class, 'health_condition_id');
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> 622f352ab3370715678069aef31c980f3053a057
