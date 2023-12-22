<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Country::create([
            'country' => 'Nigeria', 
            'currency' => 'NGN',
            'status' => true
        ]);

        Country::create([
            'country' => 'GHANA', 
            'currency' => 'GHS',
            'status' => false
        ]);

        Country::create([
            'country' => 'Kenya', 
            'currency' => 'KES',
            'status' => false
        ]);
    }
}
