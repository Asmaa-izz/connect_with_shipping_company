<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Setting::firstOrCreate(['key' =>'key'], [
            'key' => 'key',
            'value' => 'value',
        ]);

        Setting::firstOrCreate(['key' =>'logo'], [
            'key' => 'logo',
            'value' => 'logo.jpeg',
        ]);

        Setting::firstOrCreate(['key' =>'title_page'], [
            'key' => 'title_page',
            'value' => 'نظام شحن',
        ]);

        Setting::firstOrCreate(['key' =>'title_header'], [
            'key' => 'title_header',
            'value' => 'نظام شحن',
        ]);

        Setting::firstOrCreate(['key' =>'title_main'], [
            'key' => 'title_main',
            'value' => 'نظام شحن',
        ]);

        Setting::firstOrCreate(['key' =>'text_main'], [
            'key' => 'text_main',
            'value' => 'نظام تعاقد مع أكثر من شركة شحن',
        ]);

        Setting::firstOrCreate(['key' =>'img_home'], [
            'key' => 'img_home',
            'value' => 'assets/vendor/img/hero-img.png',
        ]);

        Setting::firstOrCreate(['key' =>'color'], [
            'key' => 'color',
            'value' => '#556ee6',
        ]);
    }
}
