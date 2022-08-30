<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'categoryname' => 'Test Category 1',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis enim elit, facilisis sed placerat sed, ultricies sit amet erat. Duis ac vestibulum ligula, sed mollis odio.'
        ]);
    }
}
