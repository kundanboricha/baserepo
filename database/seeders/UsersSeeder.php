<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'ulid' => Str::ulid(),
            'name' => 'Super Admin',
            'email' => 'super.admin@yopmail.com',
            'email_verified_at' => now(),
            'role' => 1,
            'password' => Hash::make("password"),
            'old_password' => Hash::make("password"),
        ]);
    }
}
