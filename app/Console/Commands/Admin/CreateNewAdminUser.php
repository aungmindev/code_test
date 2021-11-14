<?php

namespace App\Console\Commands\Admin;

use Carbon\Carbon;
use Illuminate\Console\Command;

class CreateNewAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:admin {name} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
       $user_name =  $this->argument('name');
       $password =  $this->argument('password');
       $userModel = config('auth.providers.users.model');
        $roleModel = config('laratrust.models.role');
        $user = $userModel::create([
            'active'     => true,
            'user_name'  => $user_name,
            'password'   => bcrypt($password),
            'last_login' => Carbon::now()->toDateTimeString(),
        ]);
        $user->restore();
        $role = $roleModel::whereName(config('boilerplate.auth.register_role'))->first();
        $user->roles()->sync([$role->id]);
    }
}
