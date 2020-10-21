<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commune extends Model
{
    public $table = 'communes';
    public $fillable = [
        'commune_id', 'district_id', 'name', 'lat', 'lng',
    ];
}
