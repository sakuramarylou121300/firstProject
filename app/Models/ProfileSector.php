<?php

namespace App\Models;

use App\Models\Sector;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileSector extends Model
{
    use HasFactory;

    protected $guarded = [];
    // disregard the updated_at and created_at
    public $timestamps = false;

    // emphasize the table name
    protected $table = 'profile_sector';

    // profile flood exposure belongs to table flood exposure
    public function sectors(){
        return $this->belongsTo(Sector::class, 'sector_id');
    }
}