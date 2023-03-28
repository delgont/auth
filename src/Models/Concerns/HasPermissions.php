<?php

namespace Delgont\Auth\Models\Concerns;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use Delgont\Auth\Models\Permission;
use Illuminate\Database\Eloquent\Model;

use Delgont\Auth\Exceptions\PermissionDoesNotExist;


trait HasPermissions
{

    public static function bootHasPermissions()
    {
        static::deleting(function ($model) {
            if (method_exists($model, 'isForceDeleting') && ! $model->isForceDeleting()) {
                return;
            }
            $model->permissions()->detach();
        });
    }

    /**
     * A model may have multiple permissions.
     */
    public function permissions() : BelongsToMany
    {
        return $this->morphToMany('Delgont\Auth\Models\Permission', 'model', 'model_has_permissions', 'model_id', 'permission_id');
    }

     /**
     * Determine if the model has, via roles, the given permission.
     *
     * @param \Spatie\Permission\Contracts\Permission $permission
     *
     * @return bool
     */
    protected function hasPermissionViaRole(Permission $permission): bool
    {
        return $this->hasRole($permission->roles);
    }

    /**
     * Determine if the model has the given permission.
     *
     * @return bool
     * @throws PermissionDoesNotExist
     */
    public function hasPermission($permission) : bool
    {
        if (is_string($permission)) {
            $permission = Permission::findByName($permission)->first();
        }

        if (is_int($permission)) {
            $permission = Permission::findById($permission)->first();
        }

        if (! $permission instanceof Permission) {
            throw new PermissionDoesNotExist();
        }

        return $this->permissions->contains($permission->getKeyName(), $permission->getKey());
    }


    public function givePermissionTo(...$permissions)
    {
        $permissions = collect($permissions)->flatten()->reduce(function($array, $permission){
            if ($permission instanceof Permission) {
                array_push($array, $permission->getKey());
            }

            if(is_numeric($permission)){
                array_push( $array, $permission );
            }

            if(is_string($permission)){
                $permissionModel = Permission::findByName($permission)->first();
                if ($permissionModel) {
                    array_push($array, $permissionModel->getKey());
                } else {
                    throw PermissionDoesNotExist::create($permission);
                }
                
            }


            return $array;
        }, []);

        $model = $this->getModel();
        if($model->exists){
            $this->permissions()->sync($permissions, false);
        }
        return $this;
    }

    public function withdrawPermissionsTo(...$permissions)
    {
        return $this;
    }


     /**
     * Determine if the model may perform the given permission.
     *
     * @param string|int$permission 
     *
     * @return bool
     * @throws PermissionDoesNotExist
     */
    public function hasPermissionTo($permission) : bool
    {
       return $this->hasPermission($permission);
    }


    /**
     * Remove all current permissions and set the given ones.
     *
     * @param string|int|array
     *
     * @return $this
     */
    public function syncPermissions(...$permissions)
    {
        $this->permissions()->detach();

        return $this->givePermissionTo($permissions);
    }

}