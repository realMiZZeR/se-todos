<?php

namespace Database\Seeders;

use App\Models\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = config('enums.user_roles');

        foreach ($roles as $key => $value)
        {
            UserRole::factory()
                ->create([
                    'id' => $key,
                    'title' => $value,
                ]);
        }
    }
}
