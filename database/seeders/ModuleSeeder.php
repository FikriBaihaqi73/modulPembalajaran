<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\Major;
use App\Models\User;
use App\Models\ModuleCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $majorIds = Major::pluck('id')->all();

        $mentor = User::whereHas('role', function($query) {
            $query->where('name', 'Mentor');
        })->first();

        // Jika tidak ada mentor, ambil user pertama atau user admin
        if (!$mentor) {
            $mentor = User::whereHas('role', function($query) {
                $query->where('name', 'Admin');
            })->first();
            if (!$mentor) {
                $mentor = User::first(); // Ambil user pertama jika tidak ada admin/mentor
            }
        }

        if ($mentor) {
            // Ambil semua kategori modul yang sudah ada
            $moduleCategories = ModuleCategory::all();

            foreach ($moduleCategories as $category) {
                // Buat 10 modul untuk setiap kategori
                for ($i = 1; $i <= 10; $i++) {
                    $module = Module::create([
                        'name' => $faker->unique()->sentence(rand(3, 6)),
                        'content' => $faker->paragraphs(rand(3, 7), true),
                        'thumbnail' => 'https://via.placeholder.com/640x480.png/00dddd?text=module+' . $faker->randomNumber(2),
                        'major_id' => $category->major_id,
                        'user_id' => $mentor->id,
                        'is_visible' => $faker->boolean(90),
                    ]);

                    // Lampirkan modul ke kategori ini melalui tabel pivot (menggunakan nama relasi yang benar)
                    $module->moduleCategory()->attach($category->id);
                }
            }
        }
    }
}
