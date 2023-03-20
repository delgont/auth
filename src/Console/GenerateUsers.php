<?php

namespace Delgont\Auth\Console;

use Illuminate\Console\Command;

use App\User;

use Faker\Generator as Faker;
use Illuminate\Support\Str;

class GenerateUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:users {--dummy : Generate users using dummy data...} {--count=4 : Number of users to generate}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate users ';


      /**
     * User model attributes use to display users on console
     *
     * @var array
     */
    private $attributes = ['id', 'name', 'email', 'created_at'];


    /**
     * 
     *
     * @var Faker
     */
    private $faker;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Faker $faker)
    {
        $this->faker = $faker;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
       if ($this->option('dummy')) {
            ($this->option('count') > 1) ? $this->generateDummyUsers($this->option('count')) : '';
       } else {
            ($this->option('count') > 1) ? $this->generateUsers($this->option('count')) : '';
       }
       $this->table($this->attributes, User::all($this->attributes));
    }

    private function generateUsers($count)
    {
        $users = config('users.users', []);
        if (count($users) > 0) {
            for ($i=0; $i < count($users); $i++) { 
                User::updateOrCreate($users[$i]);
            }
        }
    }

    private function generateDummyUsers($count)
    {
        for ($i=0; $i < $count; $i++) { 
            $users = User::updateOrCreate([
                'name' => $this->faker->name,
                'email' => $this->faker->email,
                'password' => bcrypt(config('users.default_password', 'secret')),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10)
            ]);
        
        }
    }
}
