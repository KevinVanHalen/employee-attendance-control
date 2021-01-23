<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('attendances')->insert([
            'date' => '2021-01-04',
            'entrance_hour' => '07:00',
            'exit_hour' => '15:00',
            'employee_id' => 1,
        ]);
        DB::table('attendances')->insert([
            'date' => '2021-01-05',
            'entrance_hour' => '07:00',
            'exit_hour' => '15:00',
            'employee_id' => 1,
        ]);
        DB::table('attendances')->insert([
            'date' => '2021-01-06',
            'entrance_hour' => '07:00',
            'exit_hour' => '15:00',
            'employee_id' => 1,
        ]);
        // DB::table('attendances')->insert([
        //     'date' => '2021-01-07',
        //     'entrance_hour' => '07:00',
        //     'exit_hour' => '15:00',
        //     'employee_id' => 1,
        // ]);
        DB::table('attendances')->insert([
            'date' => '2021-01-08',
            'entrance_hour' => '07:00',
            'exit_hour' => '15:00',
            'employee_id' => 1,
        ]);
        DB::table('attendances')->insert([
            'date' => '2021-01-11',
            'entrance_hour' => '07:00',
            'exit_hour' => '15:00',
            'employee_id' => 1,
        ]);
        DB::table('attendances')->insert([
            'date' => '2021-01-12',
            'entrance_hour' => '07:00',
            'exit_hour' => '15:00',
            'employee_id' => 1,
        ]);
        DB::table('attendances')->insert([
            'date' => '2021-01-13',
            'entrance_hour' => '07:00',
            'exit_hour' => '15:00',
            'employee_id' => 1,
        ]);
        // DB::table('attendances')->insert([
        //     'date' => '2021-01-14',
        //     'entrance_hour' => '07:00',
        //     'exit_hour' => '15:00',
        //     'employee_id' => 1,
        // ]);
        DB::table('attendances')->insert([
            'date' => '2021-01-15',
            'entrance_hour' => '07:00',
            'exit_hour' => '15:00',
            'employee_id' => 1,
        ]);

        DB::table('attendances')->insert([
            'date' => '2021-01-06',
            'entrance_hour' => '15:00',
            'employee_id' => 2,
        ]);
        DB::table('attendances')->insert([
            'date' => '2021-01-07',
            'entrance_hour' => '15:00',
            'employee_id' => 2,
        ]);
        // DB::table('attendances')->insert([
        //     'date' => '2021-01-08',
        // 'entrance_hour' => '15:00',
        //     'employee_id' => 2,
        // ]);
        DB::table('attendances')->insert([
            'date' => '2021-01-09',
            'entrance_hour' => '15:00',
            'employee_id' => 2,
        ]);
        DB::table('attendances')->insert([
            'date' => '2021-01-10',
            'entrance_hour' => '15:00',
            'employee_id' => 2,
        ]);
        DB::table('attendances')->insert([
            'date' => '2021-01-13',
            'entrance_hour' => '15:00',
            'employee_id' => 2,
        ]);
        DB::table('attendances')->insert([
            'date' => '2021-01-14',
            'entrance_hour' => '15:00',
            'employee_id' => 2,
        ]);
        // DB::table('attendances')->insert([
        //     'date' => '2021-01-15',
        // 'entrance_hour' => '15:00',
        //     'employee_id' => 2,
        // ]);
        DB::table('attendances')->insert([
            'date' => '2021-01-16',
            'entrance_hour' => '15:00',
            'employee_id' => 2,
        ]);
        DB::table('attendances')->insert([
            'date' => '2021-01-17',
            'entrance_hour' => '15:00',
            'employee_id' => 2,
        ]);
    }
}
