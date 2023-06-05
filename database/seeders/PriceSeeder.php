<?php

namespace Database\Seeders;

use App\Models\Price;
use App\Transfers\PriceType;
use Illuminate\Database\Seeder;

class PriceSeeder extends Seeder
{
    public function run(): void
    {
        Price::firstOrCreate(
            ['price' => 595, 'type' => PriceType::Monthly],
            ['remaining' => 8, 'total_available' => 20],
        );

        Price::firstOrCreate(
            ['price' => 995, 'type' => PriceType::Monthly],
            ['remaining' => 19, 'total_available' => 30],
        );
    }
}
