<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SellingPoint;

class SellingPointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
                $sections = [
            [
                'title' => 'Trust & Security',
                'description' => 'We ensure all vendors are verified and all transactions are secure...',
                'icon' => 'shield-check',
            ],
            [
                'title' => 'Customer First',
                'description' => 'Your satisfaction is our priority...',
                'icon' => 'headset',
            ],
            [
                'title' => 'Fast Delivery',
                'description' => 'We partner with reliable shipping providers...',
                'icon' => 'rocket',
            ],
            [
                'title' => 'Quality Assured',
                'description' => 'We carefully vet all vendors and products...',
                'icon' => 'award',
            ],
        ];

        foreach ($sections as $section) {
            SellingPoint::create($section);
        }
    }
}
