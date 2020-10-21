<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    public $table = 'districts';
    public $fillable = [
        'province_id', 'district_id', 'name', 'lat', 'lng',
    ];

    public function communes()
    {
        return $this->hasMany(Commune::class, 'district_id', 'district_id');
    }
}
