<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\User;

class UsersTableSeeder extends Seeder {

    public function run()
    {
        $now = Carbon::now();
        $admin = [
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678'),
            'gender' => User::SEX_MALE,
            'is_admin' => true,
            'code' => '1',
            'created_at' => $now,
            'updated_at' => $now
        ];
        
        $users = array();
        for($i=0; $i<8; $i++) {
            $users[] = [
                'name' => "user_$i",
                'email' => "user_$i@gmail.com",
                'password' => bcrypt('12345678'),
                'gender' => User::SEX_MALE,
                'code' => 2011 + $i,
                'division_id' => 2,
                'role' => 0,
                'created_at' => $now,
                'updated_at' => $now
            ];
        }
        
        User::insert($admin);
        User::insert($users);
    }

}
