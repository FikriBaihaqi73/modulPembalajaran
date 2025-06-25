<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Major;
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
        $majors = Major::all();

        User::factory()->create([
            'name' => 'Admin User',
            'username' => 'adminuser',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
        ]);

        foreach ($majors as $major) {
        User::factory()->create([
                'name' => 'Mentor ' . $major->name,
                'username' => strtolower(str_replace(' ', '', 'mentor' . $major->name)),
            'password' => Hash::make('password'),
            'role_id' => $mentorRole->id,
                'major_id' => $major->id,
        ]);

        for ($i = 1; $i <= 10; $i++) {
            User::factory()->create([
                'name' => 'Santri ' . $major->name . ' ' . $i,
                'username' => strtolower(str_replace(' ', '', 'santri' . $major->name . $i)),
                'password' => Hash::make('password'),
                'role_id' => $santriRole->id,
                'major_id' => $major->id,
            ]);
        }
        }
    }
}
