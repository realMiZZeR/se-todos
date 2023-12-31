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

        foreach ($roles as $name => $id)
        {
            UserRole::factory()
                ->create([
                    'id' => $id,
                    'title' => $name,
                ]);
        }
    }
}
