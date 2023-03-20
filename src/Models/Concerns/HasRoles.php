<?php

namespace Delgont\Auth\Models\Concerns;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use Delgont\Auth\Models\Role\Role;

use Delgont\Auth\Exceptions\RoleDoesNotExist;



trait HasRoles
{

    public static function bootHasRoles()
    {
        static::deleting(function ($model) {
            if (method_exists($model, 'isForceDeleting') && ! $model->isForceDeleting()) {
                return;
            }

            $model->roles()->detach();
        });
    }
    

    /**
     * A model may have multiple roles.
     */
    public function roles() : BelongsToMany
    {
        return $this->morphToMany('Delgont\Cms\Models\Role\Role', 'model', 'model_has_roles', 'model_id', 'role_id');
    }

     /**
     * Assign the given role to the model.
     *
     * @param array|string|int
     *
     * @return $this
     */
    public function assignRole(...$roles)
    {
        $roles = collect($roles)->flatten()->reduce(function($array, $role){
            if ($role instanceof Role) {
                array_push($array, $role->getKey());
            }

            if(is_numeric($role)){
                array_push( $array, $role );
            }

            if(is_string($role)){
                $roleModel = Role::findByName($role)->first();
                if ($roleModel) {
                    array_push($array, $roleModel->getKey());
                } else {
                    throw RoleDoesNotExist::named($role);
                }
                
            }


            return $array;
        }, []);

        $model = $this->getModel();
        if($model->exists){
            $this->roles()->sync($roles, false);
        }
        return $this;
    }
   
}