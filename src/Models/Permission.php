<?php

namespace Designbycode\RolesAndPermissions\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    
    protected $fillable = ['name'];

    /**
     * Role relationship
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permissions_roles');
    }


}
