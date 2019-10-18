<?php

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;

class MemberTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker::create('id_ID');
        $gender = $faker->randomElement(['Laki-Laki', 'Perempuan']);
        for ($i = 1; $i <= 10; $i++) {
            DB::table('members')->insert([
                'name' => $faker->name,
                'address' => $faker->address,
                'phone' => $faker->phoneNumber,
                'age' => $faker->randomDigit,
                'gender' => $gender,
            ]);
        }
    }
}
