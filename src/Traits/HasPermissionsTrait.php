<?php 

namespace Designbycode\RolesAndPermissions\Traits;

use Designbycode\RolesAndPermissions\Models\Permission;
use Designbycode\RolesAndPermissions\Models\Role;

trait HasPermissionsTrait
{


    /**
     * Roles
     */

    /**
     * Has Role
     * @param  [type]  $roles [description]
     * @return boolean        [description]
     */
    public function hasRole(...$roles)
    {
       foreach ($roles as $role) {
            if ($this->roles->contains('name', $role)){
                return true;
            }
       }

       return false;
    }


    /**
     * Asign roles to users
     * @param  [type] $role [description]
     * @return [type]       [description]
     */
    public function asignRoles (...$role)        
    {
        $role = $this->getAllRoles(array_flatten($role));

        if ($role === null) {
            return $this;
        }

        $this->roles()->saveMany($role);

        return $this;

    } 

    public function revokeRoles (...$role) 
    {
        $role = $this->getAllRoles(array_flatten($role));

        $this->roles()->detach($role);

        return $this;

    }        
    
    public function updateRoles (...$role) 
    {
        $this->roles()->detach();

        return $this->asignRoles($role);

    }        
    



    /**
     * Get all roles
     * @param  array  $role [description]
     * @return [type]       [description]
     */
    protected function getAllRoles (array $role) 
    {
        return Role::whereIn('name', $role)->get();
    }        
    
    
    

    /**
     * Permission 
     */



    /**
     *  Asign permissions to a  user
     * @param  [type] $permission [description]
     * @return [type]             [description]
     */
    public function givePermissionTo(...$permission)
    {
        $permission = $this->getAllPermissions(array_flatten($permission));

        if ($permission === null) {
            return $this;
        }

        $this->permissions()->saveMany($permission);

        return $this;

    }
    /**
     * Revoke user permissions
     * @param  [type] $permission [description]
     * @return [type]             [description]
     */
    public function withdrawPermissionTo(...$permission)
    {
        $permission = $this->getAllPermissions(array_flatten($permission));

        $this->permissions()->detach($permission);

        return $this;
    }

    /**
     * Update permissions
     * @param  [type] $permission [description]
     * @return [type]             [description]
     */
    public function updatePermission(...$permission)
    {
        $this->permissions()->detach();

        return $this->givePermissionTo($permission);
    }

    /**
     * Check if has per,issioin
     * @param  [type]  $permission [description]
     * @return boolean             [description]
     */
    protected function hasPermissionsTo($permission)
    {
        return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
    }

    /**
     * Get all permisstion
     * @param  array  $permission [description]
     * @return [type]             [description]
     */
    protected function getAllPermissions(array $permission)
    {
        return Permission::whereIn('name', $permission)->get();
    }

    /**
     * Has  permissions through role
     * @param  [type]  $permission [description]
     * @return boolean             [description]
     */
    protected function hasPermissionThroughRole($permission)
    {
        foreach ($permission->roles as $role) {
            if ($this->roles->contains($role)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Has permission
     * @param  [type]  $permission [description]
     * @return boolean             [description]
     */
    protected function hasPermission($permission)
    {
        return (bool) $this->permissions->where('name', $permission->name)->count();
    }




    /**
     * Roles relationship
     * @return [type] [description]
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'roles_users');
    }
    /**
     * permissions relationship
     * @return [type] [description]
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permissions_users');
    }





}