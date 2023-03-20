<?php

namespace Delgont\Auth;

use Illuminate\Support\Facades\Route;

use Delgont\Auth\Http\Controllers\Auth\AuthController;

class PermissionRegistrar
{
    public $source = 'config'; //database, cache, or config


    public function source($source)
    {
        $this->source = $source;
        return $this;
    }

    protected function getPermissions() :? array
    {
        return $this->getPermissionsFrom();
    }

    protected function getConfigPermission($key)
    {
        $permissions = $this->getConfigPermissions();
        if(in_array($key, $permissions)){
            return $key;
        }
        return null;
    }


    private function getPermissionsFrom() :? array
    {
        switch ($this->source) {
         case 'config':
          return config('permissions.permissions', []);
          break;

         case 'database':
          return $this->getPermissionsFromDatabase();
          break;
         default:
          return config('permissions.permissions', []);
          break;
        }
    }

    public function getPermissionsFromDatabase()
    {
        return [];
    }

}
