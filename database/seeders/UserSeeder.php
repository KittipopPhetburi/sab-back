<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // สร้าง Admin
        User::create([
            'username' => 'admin',
            'fullname' => 'ผู้ดูแลระบบ',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'role_name' => 'ผู้ดูแลระบบ',
            'status' => 'active',
        ]);

        // สร้าง Account
        User::create([
            'username' => 'account',
            'fullname' => 'พนักงานบัญชี',
            'email' => 'account@example.com',
            'password' => Hash::make('account123'),
            'role' => 'account',
            'role_name' => 'พนักงานบัญชี',
            'status' => 'active',
        ]);

        // สร้าง User ทั่วไป 3 คน
        User::create([
            'username' => 'user1',
            'fullname' => 'สมชาย ใจดี',
            'email' => 'somchai@example.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
            'role_name' => 'ผู้ใช้งาน',
            'status' => 'active',
        ]);

        User::create([
            'username' => 'user2',
            'fullname' => 'สมหญิง รักสนุก',
            'email' => 'somying@example.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
            'role_name' => 'ผู้ใช้งาน',
            'status' => 'active',
        ]);

        User::create([
            'username' => 'user3',
            'fullname' => 'วิชัย ทำงาน',
            'email' => 'wichai@example.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
            'role_name' => 'ผู้ใช้งาน',
            'status' => 'active',
        ]);
    }
}
