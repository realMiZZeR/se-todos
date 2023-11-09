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
        $roles = [
            'Пользователь',
            'Администратор',
        ];

        for ($i = 0; $i < count($roles); $i++)
        {
           UserRole::factory()->create([
               'title' => $roles[$i],
           ]);
        }
    }
}
