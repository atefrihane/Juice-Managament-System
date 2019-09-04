<?php

namespace App\Modules\Company\Models;

use App\Modules\Diractor\Models\Diractor;
use App\Modules\MachineRental\Models\MachineRental;
use App\Modules\Store\Models\Store;
use Illuminate\Database\Eloquent\Model;

class Company extends Model {

protected $fillable = ['code','status','name','country','email','tel','designation','city','zip_code','address','complement','comment','logo'];

public function stores(){
    return $this->hasMany(Store::class);
}
public function director(){
   return $this->hasOne(Diractor::class)->with('user');
}
public function getStatus(){
    $status = '';
    switch($this->status){
        case 0 : $status = 'Fermé';break;
        case 1 : $status = ' En sommeil';break;
        case 2 : $status = 'Active';break;
    }
    return $status;
}
public function getNbrStores(){
    return sizeof($this->stores);
}
public function rentedMachines(){
    $rentedMachines= [];

    foreach ($this->stores as $store){
        foreach(MachineRental::where('store_id', $store->id)->where('active', true)->get() as $machine){
            $rentedMachines[] = $machine;

        }
    }
    return $rentedMachines;
}
}
