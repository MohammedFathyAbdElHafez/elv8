<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {

            $user = User::factory()->create();

            $lastId = $user->id;

            $user->assignRole('employee');

            $user->givePermissionTo('create customers');

            $employee = Employee::create([
                'starting_date' => '2020-10-10',
                'user_id' => $lastId,
            ]);
        }
    }
}
