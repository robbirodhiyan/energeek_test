<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'username' => 'admin',
                'password' => Hash::make('password123'), // Gunakan password hashing
                'created_by' => null,
                'updated_by' => null,
                'deleted_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            [
                'name' => 'User One',
                'email' => 'user1@example.com',
                'username' => 'userone',
                'password' => Hash::make('password123'), // Gunakan password hashing
                'created_by' => 1, // ID user yang membuat (opsional)
                'updated_by' => null,
                'deleted_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
            ],
            // Tambahkan data dummy lainnya jika diperlukan
        ]);
    }
}
