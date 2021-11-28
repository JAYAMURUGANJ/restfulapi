<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => Str::random(10),
            'email' => Str::random(10).'@gmail.com',
            // 'name'=>'Jayamurugan',
            // 'email'=>'jamu03031996@gmail.com',
            'password' => bcrypt('secret'),
            'mobile_number'=>'9566632370',
            'device_name'=>'android',
            'avatar'=>'https://lh3.googleusercontent.com/ogw/ADea4I7xw7wP5VpkR_abxjereGFVYyG4sZ_Td_-96WxP=s83-c-mo',
        ]);
    }
}
