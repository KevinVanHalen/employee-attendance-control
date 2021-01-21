<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkingDaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('working_days')->insert([
            'monday' => 1,
            'tuesday' => 1,
            'wednesday' => 1,
            'thursday' => 1,
            'friday' => 1,
            'saturday' => 0,
            'sunday' => 0,
            'total_working_days' => 5,
            'employee_id' => 1,
        ]);

        DB::table('working_days')->insert([
            'monday' => 0,
            'tuesday' => 0,
            'wednesday' => 1,
            'thursday' => 1,
            'friday' => 1,
            'saturday' => 1,
            'sunday' => 1,
            'total_working_days' => 5,
            'employee_id' => 2,
        ]);
    }
}
