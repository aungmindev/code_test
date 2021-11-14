<?php

namespace Database\Seeders;

use App\Models\Client;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ClientData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        for($i = 1 ; $i <= 20 ; $i++){
            Client::create([
                "name"    => $faker->name,
                "email"   => $faker->unique()->safeEmail,
                "phone"   => $faker->phoneNumber,
                "address"   => $faker->address,
                "photo"   => 'unknown.png',
            ]);
        }
    }
}
