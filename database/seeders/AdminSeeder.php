<?php

namespace Database\Seeders;

use App\Models\Boilerplate\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userModel = config('auth.providers.users.model');
        $roleModel = config('laratrust.models.role');
        $user = $userModel::withTrashed()->updateOrCreate(['email' => 'admin@gmail.com'], [
            'active'     => true,
            'user_name'  => 'admin_user',
            'email'      => 'admin@gmail.com',
            'password'   => bcrypt('password'),
            'last_login' => Carbon::now()->toDateTimeString(),
        ]);
            $admin = $roleModel::whereName('admin')->first();
            $user->attachRole($admin);
            
    }
}
