<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use DB;
use Illuminate\Support\Str;

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
            [
                'id' => 1,
                'uuid' => Str::uuid()->toString(),
                'name' => 'DKA',
                'email' => 'davidinho241@gmail.com',
                'password' => Hash::make('password')
            ],
            [
                'id' => 2,
                'uuid' => Str::uuid()->toString(),
                'name' => 'Super Admin',
                'email' => 'admin@test.com',
                'password' => Hash::make(1234)
            ],
            [
                'id' => 3,
                'uuid' => Str::uuid()->toString(),
                'name' => 'Project Manager',
                'email' => 'pm@test.com',
                'password' => Hash::make(1234)
            ],
            [
                'id' => 4,
                'uuid' => Str::uuid()->toString(),
                'name' => 'Sales Manager',
                'email' => 'sm@test.com',
                'password' => Hash::make(1234)
            ],
            [
                'id' => 5,
                'uuid' => Str::uuid()->toString(),
                'name' => 'HR',
                'email' => 'hr@test.com',
                'password' => Hash::make(1234)
            ],
        ]);
    }
}
