<?php

namespace Delgont\Auth\Concerns;

/**
 * Commands
 */
use Delgont\Cms\Console\Commands\InstallCommand;
use Delgont\Auth\Console\GenerateUsers;


trait RegistersCommands
{
    private function registerCommands() : void
    {
        $this->commands([
            GenerateUsers::class
        ]);
    }
}