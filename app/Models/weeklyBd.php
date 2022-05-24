<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class weeklyBd extends Model
{
    //use HasFactory;
    public $table = "weekly_bds";

    protected $fillable = [
        'name',
        'hour_effort',
    ];
}
