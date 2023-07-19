<?php

namespace Delgont\Auth\Concerns;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use Delgont\Auth\Models\Role;

use Delgont\Auth\Exceptions\RoleDoesNotExist;



trait ModelHasSingleRole
{
    /**
     * A model may have a role.
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }


    /**
     * Determine if the model has (one of) the given role(s)
     *
     * @param string|int|array
     * @param string|null $guard
     * @return bool
     */
    public function hasRole($role): bool
    {
        //user does not have any role asigned to 
        if(is_null($this->role)){
            return false;
        }

        if(is_string($role)){
            return ($this->role->name == $role) ? true : false;
        }

        if(is_int($role)){
            return ($this->role->id == $role) ? true : false;
        }

        if(is_array($role)){
            return (in_array($this->role->name, $role)) ? true : false;
        }
        return false;
    }

   
}