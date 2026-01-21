<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vendor;
use App\Models\VendorProduct;
use App\Models\Category;
use App\Models\Subcategory;
use Faker\Factory as Faker;

class VendorProductSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $vendors = Vendor::all();
        $categories = Category::all();

        // 🔥 Meaningful & professional product names
        $productImages = [
            'upload/products/fan6.jpeg',
            'upload/products/fan7.jpeg',
            'upload/products/fan8.jpeg',
            'upload/products/fan9.jpeg',
            'upload/products/fan10.jpeg',

        ];
        $name=[
            'Royal Celling Fan',
            'Pure Selling Fan',
            'AL Noor Fan',
            'AutoCelling  Fan',
            'AI Celling Fan'
        ];
        $price=[
            '10004',
            '230000',
            '340000',
            '130000',
            '132000'
        ];

        for($i=0;$i<=4;$i++) {
                        VendorProduct::create([
                            'vendor_id' =>9,
                            'category_id' => 43,
                            'subcategory_id' => 37,
                            'name' => $name[$i],
                            'description' => $faker->paragraph(2),
                            'price' => $price[$i],
                            'discount' => 0,
                            'stock' => $faker->numberBetween(20, 150),
                            'meta_title' => $name[$i],
                            'meta_description' => $faker->sentence(10),
                            'product_keyword' => implode(',', $faker->words(6)),
                            'sizes' => ['S','M','L','XL'],
                            'color' => ['Black','White','Blue','Red'],
                            'specification' => $faker->sentence(6),
                            'image' => [$productImages[$i]],
                            'final_price' => $price[$i],
                        ]);

        }

        $this->command->info('Meaningful product names seeded successfully!');
    }
}
