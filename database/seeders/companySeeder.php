<?php

namespace Database\Seeders;

use App\Models\company;
use Illuminate\Database\Seeder;

class companySeeder extends Seeder
{
    public function run()
    {
        company::firstOrCreate(['name' =>'test'], [
            'name' => 'test',
        ]);
    }
}
