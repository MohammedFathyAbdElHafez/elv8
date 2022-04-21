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
        for ($i = 1; $i <= 10; $i++) {

            $user = User::factory()->create();

            $lastId = $user->id;

            $user->assignRole('employee');

            $user->givePermissionTo('create customers');

            $createEmployee = Employee::create([
                'starting_date' => '2020-10-10',
                'user_id' => $lastId,
            ]);

            $employeeId = $createEmployee->id;

            $a = rand(1, 10);
            $b = rand(1, 10);
            $c = rand(1, 10);
            if ($a != $b && $b != $c) {
                $attachedIds = [$a, $b, $c];
                $employee = Employee::find($employeeId);
                $employee->customers()->sync($attachedIds);
            }

        }
    }
}
