<?php

namespace App\Modules\User\Models;

use App\Modules\Order\Models\Order;
use App\Modules\Store\Models\StoreProductHistory;
use App\Modules\User\Models\ContactHistory;
use App\Modules\User\Models\Director;
use App\Modules\User\Models\Responsible;
use App\Modules\Warehouse\Models\Warehouse;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    protected $appends = ['userType'];

    protected $fillable = [
        'email',
        'password',
        'code',
        'nom',
        'prenom',
        'civilite',
        'telephone',
        'accessCode',
        'password',
        'child_type',
        'child_id',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function child()
    {
        return $this->morphTo();
    }
    public function getType()
    {

        switch ($this->child_type) {
            case Responsible::class:return 'Autre';
                break;
            case Director::class:return 'Directeur';
                break;
        }
        return 'admin';
    }

    public function getuserTypeAttribute()
    {
        return $this->getType();

    }

    public function DBO()
    {
        return $this->child->role->role_name == 'DBO';
    }
    public function superAdmin()
    {
        return $this->child->role->role_name == 'SUPERADMIN';
    }

    public function admin()
    {
        return $this->child->role->role_name == 'ADMIN';
    }

    public function preparator()
    {
        return $this->child->role->role_name == 'PREPARATOR';
    }

    public function mainDelivery()
    {
        return $this->child->role->role_name == 'MAIN_DELIVERY';

    }
    public function secondDelivery()
    {
        return $this->child->role->role_name == 'SECOND_DELIVERY';

    }

    public function primaryAdmin()
    {
        return $this->DBO() or $this->superAdmin() or $this->admin();

    }

    public function preparatorAdmin()
    {
        return $this->DBO() or $this->superAdmin() or $this->admin() or $this->preparator();

    }

    public function formatName()
    {
        return ucfirst($this->nom) . ' ' . ucfirst($this->prenom);
    }

    public function warehouses()
    {
        return $this->hasMany(Warehouse::class);
    }

    public function prepares()
    {
        return $this->hasMany(Order::class);
    }
    public function delivries()
    {
        return $this->hasMany(Order::class);
    }
    public function histories()
    {
        return $this->hasMany(ContactHistory::class, 'contact_id', 'id');

    }

    public function storeProductHistories()
    {
        return $this->hasMany(StoreProductHistory::class);

    }

    public function receivesBroadcastNotificationsOn()
    {

        return 'user-' . $this->id;

    }

}
