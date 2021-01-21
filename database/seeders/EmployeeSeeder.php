<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employees')->insert([
            'last_name_1' => 'Perez',
            'last_name_2' => 'Rodriguez',
            'first_name' => 'Leslie',
            'password' => Hash::make('contraseña'),
            'status' => 1,
        ]);

        DB::table('employees')->insert([
            'last_name_1' => 'Morales',
            'last_name_2' => 'Ochoa',
            'first_name' => 'Francisco',
            'password' => Hash::make('12345678'),
            'status' => 1,
        ]);
    }
}
