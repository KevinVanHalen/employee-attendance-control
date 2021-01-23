<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NonAttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('non_attendances')->insert([
            'date' => '2021-01-07',
            'justified' => 1,
            'reason' => 'Enfermedad',
            'employee_id' => 1,
        ]);
        DB::table('non_attendances')->insert([
            'date' => '2021-01-08',
            'justified' => 0,
            'employee_id' => 2,
        ]);
        DB::table('non_attendances')->insert([
            'date' => '2021-01-14',
            'justified' => 0,
            'employee_id' => 1,
        ]);
        DB::table('non_attendances')->insert([
            'date' => '2021-01-15',
            'justified' => 1,
            'reason' => 'Asunto personal',
            'employee_id' => 2,
        ]);
    }
}
