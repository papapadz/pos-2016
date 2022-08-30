<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $seeders = array (
            'EmployeeSeeder', 
            'CategorySeeder', 
            'SupplierSeeder',
            'ProductSeeder'
        );
        foreach ($seeders as $seeder)
        { 
           $this->call($seeder);
        }

        Model::reguard();
    }
}
