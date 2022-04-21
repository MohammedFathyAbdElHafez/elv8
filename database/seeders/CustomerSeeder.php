<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 0; $i < 10; $i++) {

            $user = User::factory()->create();

            $lastId = $user->id;

            $user->assignRole('customer');

            if ($i <= 3) {
                $action = 1;
            } else if ($i <= 6) {
                $action = 2;
            } else {
                $action = 3;
            }
            $customer = Customer::create([
                'user_id' => $lastId,
                'mobile'  => $faker->countryCode() . $faker->phoneNumber(),
                'country'  => $faker->country(),
                'city'  => $faker->city(),
                'postal_code'  => $faker->postcode(),
                'address'  => $faker->address(),
                'action_id'  => $action,
            ]);
        }
    }
}
