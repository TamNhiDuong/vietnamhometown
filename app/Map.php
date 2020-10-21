<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Map extends Model
{
    public $table = 'maps';
    public $fillable = [
        'title', 'type', 'description', 'lat', 'lng', 'sync_id', 'province_id', 'district_id', 'commune_id'
    ];
}
