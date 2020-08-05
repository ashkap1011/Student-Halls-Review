<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dorm extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'dorm_id';
    protected $casts = [
        'amenities' => 'array'
    ];
}
