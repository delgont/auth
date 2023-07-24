<?php

namespace Delgont\Auth;

use Delgont\Auth\Models\Permission;
use Delgont\Auth\Models\PermissionGroup;


abstract class PermissionRegistrar
{
    protected $group = null;
    protected $permissions = null;


    protected function getGroup()
    {
        return $this->group;
    }

    public function getPermissions()
    {
        return ($this->permissions) ? $permissions : (new \ReflectionClass($this))->getConstants();
    }

    public function sync()
    {
        $permissionGroup = ($this->getGroup()) ? PermissionGroup::firstOrCreate([
            'name' => $this->getGroup()
        ],['name' => get_class($this), 'registrar' => get_class($this)]) : null;

        if (count($this->getPermissions()) > 0) {
            foreach ($this->getPermissions() as $key => $permission) {
                Permission::updateOrCreate([
                    'name' => $permission
                ], [
                    'name' => $permission,
                    'permission_group_id' => ($permissionGroup) ? $permissionGroup->id : null
                ]);
            }
        }
    }

    public function cache()
    {

    }
}
