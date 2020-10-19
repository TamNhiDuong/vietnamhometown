<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Map extends Model
{
    public $table = 'maps';
    public $fillable = [
        'title', 'type', 'description','lat','lng'
    ];
}
