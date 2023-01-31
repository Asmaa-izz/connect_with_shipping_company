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
        $city1 = City::firstOrCreate(['name' => 'القاهرة'], [
            'name' => 'القاهرة',
        ]);

        $area1 = Area::firstOrCreate(['name' => 'شمال القاهرة'], [
            'name' => 'شمال القاهرة',
            'city_id' => $city1->id,
        ]);

        $neighborhood1 = Neighborhood::firstOrCreate(['name' => 'حي القاهرة'], [
            'name' => 'حي القاهرة',
            'area_id' => $area1->id,
        ]);

        $neighborhood2 = Neighborhood::firstOrCreate(['name' => 'حي القاهرة2'], [
            'name' => 'حي القاهرة2',
            'area_id' => $area1->id,
        ]);
    }
}
