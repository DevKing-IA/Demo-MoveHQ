<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use MovehqApp\Models\User;
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
        if (app()->environment('production')) {
            echo "UserSeeder should not be run on prod server\n";
            return;
        }

        DB::table('users')->truncate();
        $password = Hash::make('password');

        $data = [
            [
                'name' => 'Admin User',
                'email' => 'admin@admin.com',
                'email_verified_at' => now(),
                'password' => $password,
                'remember_token' => Str::random(10),
                'created_at' => '2021-04-05 16:42:20',
                'updated_at' => '2022-04-05 16:42:20',
                'deleted_at' => NULL,
            ],
        ];

        User::insert($data);
    }
}
