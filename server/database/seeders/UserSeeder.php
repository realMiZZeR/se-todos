<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = config('enums.user_roles');

        // Create default user.
        User::factory()
            ->create([
                'name' => 'Max',
                'email' => 'maxcan2work@gmail.com',
                'password' => 'pass',
                'role_id' => $role['guest'],
            ]);

        // Create admin.
        User::factory()
            ->create([
                'name' => 'admin',
                'email' => 'admin@se.com',
                'password' => 'pass',
                'role_id' => $role['admin'],
            ]);
    }
}
