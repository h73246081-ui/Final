<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AboutStat;

class AboutStatsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
                $stats = [
            [
                'icon' => 'Package',
                'value' => 100000,
                'suffix' => '+',
                'label' => 'Active Products',
                'color' => 'from-blue-500 to-indigo-600',
            ],
            [
                'icon' => 'Users',
                'value' => 50000,
                'suffix' => '+',
                'label' => 'Happy Customers',
                'color' => 'from-purple-500 to-pink-600',
            ],
            [
                'icon' => 'Store',
                'value' => 2500,
                'suffix' => '+',
                'label' => 'Verified Vendors',
                'color' => 'from-orange-500 to-red-500',
            ],
            [
                'icon' => 'ShoppingCart',
                'value' => 200000,
                'suffix' => '+',
                'label' => 'Orders Delivered',
                'color' => 'from-green-500 to-emerald-600',
            ]
        ];

        foreach ($stats as $stat) {
            AboutStat::create($stat);
        }
    }
}
