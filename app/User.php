<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\Hash;
use App\Role;
use App\User;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    public function getJWTCustomClaims()
    {
        return [];
    }
    protected $fillable = [
        'name', 'email', 'password', 'direccion', 'documento'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'users_roles');
    }

    public function permisoruta($permiso)
    {

        foreach ($this->roles as $role) {
            if ($role->rname == "administrador") {
                return true;
            }

            foreach ($role->permisos as $permis) {

                if (in_array($permis->slug, $permiso)) {
                    return true;
                }
            }
        }
    }

    public function permisosadmin($permisadmin)
    {

        foreach ($this->roles as $role) {
            if ($role->rname == "administrador") {
                return true;
            }
            foreach ($role->permisos as $permis) {

                if ($permis->entrada == "yes" && in_array($permis->slug, $permisadmin)) {

                    return true;
                }
            }
        }
        return false;
    }

    public function listar($user, $lists)
    {

        $per = $user->with("roles", "roles.permisos")->where('id', auth()->user()->id)->get();

        $arrpermi = [];
        foreach ($per as $res) {

            foreach ($res->roles as $permi) {
                if ($permi->name == "administrador") {
                    return true;
                }
                foreach ($permi->permisos as $ern) {
                    array_push($arrpermi, $ern);
                }
            }
        }


        foreach ($arrpermi as $permi) {

            if (($permi->entrada == "yes" &&  $permi->slug == $lists)) {
                return true;
            }
        }
        return false;
    }

    public function siexite($permi, $lists)
    {
        if (($permi->entrada == "yes" &&  $permi->slug == $lists)) {
            return true;
        }
    }
}
