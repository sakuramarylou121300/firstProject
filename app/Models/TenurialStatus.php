<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenurialStatus extends Model
{
    use HasFactory;

    protected $guarded = [];
    // disregard the updated_at and created_at
    public $timestamps = false;
}