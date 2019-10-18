<?php

use App\Model\Unit;
use Illuminate\Database\Seeder;

class UnitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Unit::truncate();

        Unit::create(['name' => 'Customer Service']);
        Unit::create(['name' => 'Perawatan']);
        Unit::create(['name' => 'Apotek']);
    }
}
