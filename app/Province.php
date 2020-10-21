<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    public $table = 'provinces';
    public $fillable = [
        'province_id', 'name', 'lat', 'lng',
    ];

    public function districts()
    {
        return $this->hasMany(District::class, 'province_id', 'province_id');
    }
}
