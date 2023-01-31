<?php

namespace Database\Seeders;

use App\Models\company;
use Illuminate\Database\Seeder;

class companySeeder extends Seeder
{
    public function run()
    {
        Company::firstOrCreate(['name' =>'speedaf'], [
            'name' => 'speedaf',
        ]);

        Company::firstOrCreate(['name' =>'speedaf'], [
            'name' => 'speedaf',
        ]);

        Company::firstOrCreate(['name' =>'speedaf'], [
            'name' => 'speedaf',
        ]);
    }
}
