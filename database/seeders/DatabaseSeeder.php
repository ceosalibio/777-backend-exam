<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        User::truncate();

        User::create([
            'username' => 'manager',
            'name'     => 'Pedro Gil',
            'role'     => 'Manager',
            'password'=>Hash::make('123456'),
        ]);

        User::create([
            'username' => 'developer',
            'name'     => 'Gil Puyat',
            'role'     => 'Web Developer',
            'password'  => Hash::make('123456'),
        ]);

        User::create([
            'username' => 'designer',
            'name'     => 'Juan Luna',
            'role'     => 'Web Designer',
            'password' => Hash::make('123456'),
        ]);
    }
}
