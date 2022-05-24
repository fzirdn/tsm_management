<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dailyBd extends Model
{
    //use HasFactory;
    public $table = "daily_bds";

    protected $fillable = [
        'name',
        'hour_effort',
    ];
}
