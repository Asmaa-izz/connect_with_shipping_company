<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\City;
use App\Models\Neighborhood;
use Illuminate\Database\Seeder;

class ShippingSeeder extends Seeder
{
    public function run()
    {
        $city1 = City::firstOrCreate(['name' => 'القاهرة'], ['name' => 'القاهرة']);
        City::firstOrCreate(['name' => 'الجيزة'], ['name' => 'الجيزة']);
        City::firstOrCreate(['name' => 'أسوان'], ['name' => 'أسوان']);
        City::firstOrCreate(['name' => 'أسيوط'], ['name' => 'أسيوط']);
        City::firstOrCreate(['name' => 'بني سويف'], ['name' => 'بني سويف']);
        City::firstOrCreate(['name' => 'القليوبية'], ['name' => 'القليوبية']);
        City::firstOrCreate(['name' => 'البحيرة'], ['name' => 'البحيرة']);
        City::firstOrCreate(['name' => 'دمياط'], ['name' => 'دمياط']);
        City::firstOrCreate(['name' => 'البحر الأحمر'], ['name' => 'البحر الأحمر']);
        City::firstOrCreate(['name' => 'الإسماعيلية'], ['name' => 'الإسماعيلية']);
        City::firstOrCreate(['name' => 'كفر الشيخ'], ['name' => 'كفر الشيخ']);
        City::firstOrCreate(['name' => 'الأقصر'], ['name' => 'الأقصر']);

        $area1 = Area::firstOrCreate(['name' => 'عابدين'], ['name' => 'عابدين','city_id' => $city1->id]);
        Area::firstOrCreate(['name' => 'العباسية'], ['name' => 'العباسية','city_id' => $city1->id]);
        Area::firstOrCreate(['name' => 'الأزبكية'], ['name' => 'الأزبكية','city_id' => $city1->id]);
        Area::firstOrCreate(['name' => 'القطامية'], ['name' => 'القطامية','city_id' => $city1->id]);
        Area::firstOrCreate(['name' => 'المنيل'], ['name' => 'المنيل','city_id' => $city1->id]);
        Area::firstOrCreate(['name' => 'المقطم'], ['name' => 'المقطم','city_id' => $city1->id]);


        Neighborhood::firstOrCreate(['name' => 'حي 1'], ['name' => 'حي 1','area_id' => $area1->id,]);
        Neighborhood::firstOrCreate(['name' => 'حي 2'], ['name' => 'حي 2','area_id' => $area1->id,]);

    }
}
