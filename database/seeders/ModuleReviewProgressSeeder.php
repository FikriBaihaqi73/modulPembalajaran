<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\User;
use App\Models\ModuleReview;
use App\Models\ModuleProgress;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ModuleReviewProgressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $modules = Module::all();
        $santriUsers = User::whereHas('role', function ($query) {
            $query->where('name', 'Santri');
        })->get();

        foreach ($modules as $module) {
            // Get santri belonging to the same major as the module
            $santriForMajor = $santriUsers->where('major_id', $module->major_id);

            // Ensure there are enough santri to assign progress
            if ($santriForMajor->count() >= 10) {
                $completedSantri = $santriForMajor->take(5);
                $uncompletedSantri = $santriForMajor->skip(5)->take(5);

                // Set progress for completed santri
                foreach ($completedSantri as $santri) {
                    ModuleProgress::create([
                        'user_id' => $santri->id,
                        'module_id' => $module->id,
                        'is_completed' => true,
                    ]);
                }

                // Set progress for uncompleted santri
                foreach ($uncompletedSantri as $santri) {
                    ModuleProgress::create([
                        'user_id' => $santri->id,
                        'module_id' => $module->id,
                        'is_completed' => false,
                    ]);
                }
            } else {
                // Handle cases where not enough santri are available,
                // for simplicity, we'll mark all available santri as completed for this module
                // or just skip if there are too few
                foreach ($santriForMajor as $santri) {
                    ModuleProgress::create([
                        'user_id' => $santri->id,
                        'module_id' => $module->id,
                        'is_completed' => $faker->boolean(50), // Random completion for fewer santri
                    ]);
                }
            }

            // Create 4 reviews for each module from random santri
            $reviewers = $santriForMajor->shuffle()->take(4); // Take 4 random santri from this major
            foreach ($reviewers as $reviewer) {
                // Ensure the reviewer has completed the module before reviewing
                $progress = ModuleProgress::where('user_id', $reviewer->id)
                                          ->where('module_id', $module->id)
                                          ->first();

                if ($progress && $progress->is_completed) {
                    ModuleReview::create([
                        'module_id' => $module->id,
                        'user_id' => $reviewer->id,
                        'rating' => $faker->numberBetween(1, 5),
                        'comment' => $faker->paragraph(rand(1, 3)),
                    ]);
                }
            }
        }
    }
}
