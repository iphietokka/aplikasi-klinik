<?php

use Illuminate\Database\Seeder;
use App\Model\Setting;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::truncate();

        $employee = new Setting();
        $employee->company_name = 'Klinik Bekaskaki';
        $employee->address = 'Jalan Cik Ditiro No.24';
        $employee->email = 'klinik@mail.com';
        $employee->phone =  19191919191;
        $employee->alert_product = 10;
        $employee->save();
    }
}
