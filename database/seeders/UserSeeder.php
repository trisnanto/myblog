<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Anto Admin',
            'username' => 'trisnanto',
            'email' => 'trisnanto@gmail.com',
            'email_verified_at' => now(),
            'password' => '12341234',
            'remember_token' => Str::random(10),
        ]);

        User::factory(4)->create();
    }
}
