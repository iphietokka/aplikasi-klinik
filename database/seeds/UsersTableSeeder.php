<?php

use Illuminate\Database\Seeder;

use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        $employee = new User();
        $employee->name = 'Administrator';
        $employee->username = 'admin';
        $employee->active = 1;
        $employee->role_id = 1;
        $employee->password = bcrypt('123456');
        $employee->save();


        $manager = new User();
        $manager->name = 'Muhammad Iradat ';
        $manager->username = 'user1';
        $manager->active = 1;
        $manager->role_id = 2;
        $manager->password = bcrypt('123456');
        $manager->save();

        $manager = new User();
        $manager->name = 'Muhammad Abdul Iradat';
        $manager->username = 'bekaskaki';
        $manager->active = 1;
        $manager->role_id = 2;
        $manager->password = bcrypt('123456');
        $manager->save();
    }
}
