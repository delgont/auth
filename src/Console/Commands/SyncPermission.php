<?php

namespace Delgont\Auth\Console\Commands;

use Illuminate\Console\Command;

class SyncPermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync permissions';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $permissions =  config('permissions.permission_registrars');
        if (is_array($permissions) && count($permissions) > 0) {
            $this->info('sycing the permissions');
            foreach ($permissions as $permission) {
                app($permission)->sync();
            }
            $this->info('Done .....................*');
        }else{
            $this->info('no permssions to sync');
        }
    }
}
