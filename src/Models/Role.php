<?php

namespace Designbycode\RolesAndPermissions\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    protected $fillable = ['name'];

    /**
     * Permission relationship
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permissions_roles');
    }



}
