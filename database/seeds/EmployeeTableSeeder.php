<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Model\Unit;

class EmployeeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        for ($i = 1; $i <= 10; $i++) {
            DB::table('employees')->insert([
                'name' => $faker->name,
                'address' => $faker->address,
                'phone' => $faker->phoneNumber,
                'unit_id' => Unit::pluck('id')->random(),
            ]);
        }
    }
}
