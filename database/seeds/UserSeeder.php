<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'     => 'Main Manager',
            'phone'    => '+79998887766',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);
    }
}
