<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Role;

class Permiso extends Model
{
    public function roles()
    {
        return $this->belongsToMany(Role::class); //->withTimestamps();
    }
}
