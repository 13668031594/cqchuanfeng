<?php

use Illuminate\Database\Seeder;

class TietongMasterTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $master = new \App\Models\Tietong\TietongMaster();
        $master->young_account_number = 'admins';
        $master->password = \Illuminate\Support\Facades\Hash::make('asdasd123');
        $master->young_nickname = '超级管理员';
        $master->save();

    }
}
