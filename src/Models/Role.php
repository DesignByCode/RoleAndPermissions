<?php

namespace Designbycode\RolesAndPermissions\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    /**
     * Permission relationship
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permissions_roles');
    }



}
