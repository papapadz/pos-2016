<?php

use Illuminate\Database\Seeder;
use App\Product;
use App\Delivery;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'productcode' => '1XXX0',
            'productname' => 'Test Product 1',
            //'pattern' => 'XXXX',
            'unitprice' => 100.00,
            //'set_price' => 100.00,
            'stock' => 100,
            'reorderlimit' => 10,
            'category_id' => 1,
            //'supplier_id' => 1,
            'status' => 0,
            //'unitcost' => 110.00,
            //'percentage' => 10,
            //'markup' => 10
        ]);
    }
}
