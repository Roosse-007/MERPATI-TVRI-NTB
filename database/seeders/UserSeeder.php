<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(

            [
                'email' => 'admin@tvrintb.go.id'
            ],

            [
                'name' => 'Administrator',

                'unit_kerja_id' => 1,

                'jabatan_id' => 17,

                'nip' => '000000000001',

                'username' => 'admin',

                'password' => Hash::make('admin123'),

                'is_active' => true,
            ]

        );

        $admin->assignRole('Admin');
    }
}