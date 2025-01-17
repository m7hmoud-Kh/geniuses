<?php

namespace Database\Seeders;

use App\Models\Setting;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();

        /*****Home Section***** */
        Setting::create([
            'key' => 'home_title',
            'value_en' => 'home_title english',
            'value_ar' => 'home_title arabic',
        ]);

        Setting::create([
            'key' => 'home_sub_title',
            'value_en' => 'home_sub_title english',
            'value_ar' => 'home_sub_title arabic',
        ]);

        Setting::create([
            'key' => 'home_banner',
            'image' => 'image.png',
        ]);

        /******About******** */
        Setting::create([
            'key' => 'about_title',
            'value_en' => 'home_sub_title english',
            'value_ar' => 'home_sub_title arabic',
        ]);

        Setting::create([
            'key' => 'about_banner',
            'image' => 'image.png',
        ]);

        /*********why learn******** */
        Setting::create([
            'key' => 'why_learn_title',
            'value_en' => 'home_sub_title english',
            'value_ar' => 'home_sub_title arabic',
        ]);

        Setting::create([
            'key' => 'why_learn_pargraph',
            'value_en' => 'home_sub_title english',
            'value_ar' => 'home_sub_title arabic',
        ]);

        Setting::create([
            'key' => 'why_learn_banner',
            'image' => 'image.png',
        ]);

        Setting::create([
            'key' => 'why_learn_item_one',
            'value_en' => 'home_sub_title english',
            'value_ar' => 'home_sub_title arabic',
        ]);

        Setting::create([
            'key' => 'why_learn_item_two',
            'value_en' => 'home_sub_title english',
            'value_ar' => 'home_sub_title arabic',
        ]);

        Setting::create([
            'key' => 'why_learn_item_three',
            'value_en' => 'home_sub_title english',
            'value_ar' => 'home_sub_title arabic',
        ]);
        /**********Adv******** */
        Setting::create([
            'key' => 'advantage_one_text',
            'value_en' => 'home_sub_title english',
            'value_ar' => 'home_sub_title arabic',
        ]);

        Setting::create([
            'key' => 'advantage_two_text',
            'value_en' => 'home_sub_title english',
            'value_ar' => 'home_sub_title arabic',
        ]);

        Setting::create([
            'key' => 'advantage_three_text',
            'value_en' => 'home_sub_title english',
            'value_ar' => 'home_sub_title arabic',
        ]);

        Setting::create([
            'key' => 'advantage_one_pargraph',
            'value_en' => 'home_sub_title english',
            'value_ar' => 'home_sub_title arabic',
        ]);

        Setting::create([
            'key' => 'advantage_two_pargraph',
            'value_en' => 'home_sub_title english',
            'value_ar' => 'home_sub_title arabic',
        ]);

        Setting::create([
            'key' => 'advantage_three_pargraph',
            'value_en' => 'home_sub_title english',
            'value_ar' => 'home_sub_title arabic',
        ]);
    }
}
