<?php

namespace Database\Seeders;

use App\Models\customerActions;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class customerActionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $actions = [
            ['action_name' => 'call'],
            ['action_name' => 'visit'],
            ['action_name' => 'follow_up']
        ];

        array_map(fn ($action) => customerActions::create($action), $actions);
    }
}
