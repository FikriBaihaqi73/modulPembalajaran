<?php

namespace Database\Seeders;

use App\Models\ModuleCategory;
use App\Models\Major;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $majors = Major::all();

        foreach ($majors as $major) {
            for ($i = 1; $i <= 5; $i++) {
                ModuleCategory::create([
                    'name' => $faker->unique()->word . ' Category for ' . $major->name,
                    'major_id' => $major->id,
                ]);
            }
        }
    }
}
