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
        // Create default users.
        User::factory()
            ->count(2)
            ->create();

        // Create administrator.
        User::factory()
            ->create([
                'role_id' => DB::table('user_roles')->where('title', '=', 'Администратор')->first()->id,
            ]);
    }
}
