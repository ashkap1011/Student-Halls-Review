<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IntercollegiateDorm extends Model
{   
    protected $primaryKey = 'dorm_id';
    public $timestamps = false;

    protected $casts = [
        'uni_id_set' => 'array'
    ];
}
