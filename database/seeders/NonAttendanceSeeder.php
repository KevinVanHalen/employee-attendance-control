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
            'date' => '2020-01-07',
            'justified' => 1,
            'reason' => 'Enfermedad',
            'employee_id' => 1,
        ]);
        DB::table('non_attendances')->insert([
            'date' => '2020-01-08',
            'justified' => 0,
            'employee_id' => 2,
        ]);
    }
}
