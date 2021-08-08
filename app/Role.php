<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Permiso;

class Role extends Model
{
    //

    public function users()
    {

        return $this->belongsToMany(User::class, 'users_roles'); //->withTimestamps();
    }

    public function permisos()
    {

        return $this->belongsToMany(Permiso::class, 'roles_permisos'); //->withTimestamps();
    }
}
