<?php

namespace Database\Seeders;

use App\Models\Billing;
use App\Models\Client;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
class BillingData extends Seeder
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
            Billing::create([
                "amount"    => $faker->numberBetween(1000,100000),
                "due_date"   => $faker->dateTime($max = 'now', $timezone = null),
                "description"   => $faker->text,
                "client_id"   => $i,
            ]);
        }
    }
}
