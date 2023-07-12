<?php

namespace Delgont\Auth\Concerns;

/**
 * Commands
 */

use Delgont\Cms\Console\Commands\InstallCommand;
use Delgont\Auth\Console\GenerateUsers;
use Delgont\Auth\Console\GeneratePermissions;
use Delgont\Auth\Console\MakeUserType;


trait RegistersCommands
{
    private function registerCommands() : void
    {
        $this->commands([
            GenerateUsers::class,
            GeneratePermissions::class,
            MakeUserType::class,
        ]);
    }
}