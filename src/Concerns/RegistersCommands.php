<?php

namespace Delgont\Auth\Concerns;

/**
 * Commands
 */

use Delgont\Auth\Console\Commands\GeneratePermissions;
use Delgont\Auth\Console\Commands\MakeUserType;
use Delgont\Auth\Console\Commands\MakeAddRoleIdToModelTable;
use Delgont\Auth\Console\Commands\SyncPermission;
use Delgont\Auth\Console\Commands\SyncRole;

use Delgont\Auth\Console\Commands\MakePermissionRegistrar;
use Delgont\Auth\Console\Commands\MakeRoleRegistrar;
use Delgont\Auth\Console\Commands\RoleCacheCommand;


trait RegistersCommands
{
    private function registerCommands() : void
    {
        $this->commands([
            GeneratePermissions::class,
            MakeUserType::class,
            MakeAddRoleIdToModelTable::class,
            SyncPermission::class,
            SyncRole::class,
            MakePermissionRegistrar::class,
            MakeRoleRegistrar::class,
            RoleCacheCommand::class
        ]);
    }
}