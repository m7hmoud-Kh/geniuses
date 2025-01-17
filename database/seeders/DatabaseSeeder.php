<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Exam;
use App\Models\Fqa;
use App\Models\Influencer;
use App\Models\Instructor;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Admin::factory()->count(1)->create();
        Influencer::factory()->count(10)->create();
        User::factory()->count(1)->create();
        Instructor::factory()->count(10)->create();
        Category::factory()->count(20)->create();
        Module::factory()->count(60)->create();
        Fqa::factory()->count(50)->create();
        Exam::factory()->count(10)->create();
        Lesson::factory()->count(20)->create();
        Subscription::factory()->count(5)->forCategory()->create();
        Subscription::factory()->count(5)->forModule()->create();

        $this->call([
            SettingSeeder::class
        ]);
    }
}
