<?php

namespace App\Modules\General\Models;

use App\Modules\Company\Models\Company;
use App\Modules\General\Models\City;
use App\Modules\Store\Models\Store;
use App\Modules\Warehouse\Models\Warehouse;
use Illuminate\Database\Eloquent\Model;

class Zipcode extends Model
{

    protected $fillable = ['code', 'city_id'];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');

    }

    public function companies()
    {
        return $this->hasMany(Company::class);

    }

    public function stores()
    {
        return $this->hasMany(Store::class);

    }
    public function warehouses()
    {
        return $this->hasMany(Warehouse::class);

    }

  

}
