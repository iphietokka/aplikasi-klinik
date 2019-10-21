<?php

use App\Model\Category;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::truncate();

        Category::create(['name' => 'Anti Aging']);
        Category::create(['name' => 'Cleansing']);
        Category::create(['name' => 'Sun Protection']);
        Category::create(['name' => 'Moisturizing']);
        Category::create(['name' => 'Peeling']);
        Category::create(['name' => 'Brightening']);
    }
}
