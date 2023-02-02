<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class companySeeder extends Seeder
{
    public function run()
    {
        Company::firstOrCreate(['name' =>'speedaf'], [
            'name' => 'speedaf',
        ]);

        Company::firstOrCreate(['name' =>'J&T'], [
            'name' => 'J&T',
        ]);

        Company::firstOrCreate(['name' =>'Mylerz'], [
            'name' => 'Mylerz',
        ]);
    }
}
