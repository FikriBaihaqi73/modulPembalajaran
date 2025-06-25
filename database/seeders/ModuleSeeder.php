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

        $technologyPexelsImages = [
            'https://images.pexels.com/photos/1779487/pexels-photo-1779487.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
            'https://images.pexels.com/photos/3861969/pexels-photo-3861969.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
            'https://images.pexels.com/photos/2007604/pexels-photo-2007604.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
            'https://images.pexels.com/photos/416405/pexels-photo-416405.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
            'https://images.pexels.com/photos/546819/pexels-photo-546819.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
            'https://images.pexels.com/photos/2653362/pexels-photo-2653362.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
        ];

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
                        'content' => $faker->sentences(rand(3, 5), true),
                        'thumbnail' => $faker->randomElement($technologyPexelsImages),
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
