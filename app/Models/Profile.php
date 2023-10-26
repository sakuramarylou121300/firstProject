<?php

namespace App\Models;

use App\Models\ProfileFloodExposure;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model{
    use HasFactory;

    // all fillable
    protected $guarded = [];
    // disregard the updated_at and created_at
    public $timestamps = false;

}
