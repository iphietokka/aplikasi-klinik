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

        Category::create(['name' => 'Obat Cair']);
        Category::create(['name' => 'Obat Luar']);
        Category::create(['name' => 'Obat Luka']);
    }
}
