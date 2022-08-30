<?php

use Illuminate\Database\Seeder;
use App\Employee;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Employee::create([
            'employeename' => 'Admin',
            'position' => 1,
            'username' => 'admin',
            'password' => 'password',
            'address' => 'Test',
            'contactno' => '12346789',
            'email' => 'binarybee.solutions.ads@gmail.com'
        ]);
    }
}
