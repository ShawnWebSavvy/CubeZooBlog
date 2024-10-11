<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin',
            'surname' => 'Admin',
            'email' => 'admin@admin.co.za',
            'password' => bcrypt('P@55word'),
            'role' => 'admin',
        ]);

        // Create Author User
        User::create([
            'name' => 'Author',
            'surname' => 'Author',
            'email' => 'author@author.co.za',
            'password' => bcrypt('P@55word'),
            'role' => 'author',
        ]);
    }
}
