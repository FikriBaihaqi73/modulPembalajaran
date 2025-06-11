<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'Admin')->first();
        $mentorRole = Role::where('name', 'Mentor')->first();
        $santriRole = Role::where('name', 'Santri')->first();

        User::factory()->create([
            'name' => 'Admin User',
            'username' => 'adminuser',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
        ]);

        User::factory()->create([
            'name' => 'Mentor User',
            'username' => 'mentoruser',
            'password' => Hash::make('password'),
            'role_id' => $mentorRole->id,
        ]);

        User::factory()->create([
            'name' => 'Santri User',
            'username' => 'santriuser',
            'password' => Hash::make('password'),
            'role_id' => $santriRole->id,
        ]);
    }
}
