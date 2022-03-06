<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Str;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        foreach (range(1, 10) as $value) {
            DB::table('products')->insert([
                'name' => $faker->name,
                'description' => $faker->paragraph,
                'quantity' => $faker->numberBetween($min = 1, $max = 50),
                'price' => $faker->numberBetween($min = 1, $max = 500),
            ]);
        }
    }
}
