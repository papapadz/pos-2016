<?php

use Illuminate\Database\Seeder;
use App\Supplier;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Supplier::create([
            'companyname' => 'Test Company 1',
            'owner_name' => 'Test, Test',
            'contactno' => '123456789',
            'address' => 'Test Address',
            'tin' => '123456789',
        ]);
    }
}
