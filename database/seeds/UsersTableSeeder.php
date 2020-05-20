<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'email'    => 'superadmin@localhost.com',
            'password' => bcrypt('123456'),
            'name'     => 'Super Admin',
        ]);

        DB::table('users')->insert([
            'email'    => 'customer1@localhost.com',
            'password' => bcrypt('123456'),
            'name'     => 'Customer 1',
        ]);
    }
}
