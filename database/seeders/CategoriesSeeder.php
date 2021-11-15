<?php

namespace Database\Seeders;

use App\Models\Category;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for ($i = 1; $i <= 5; $i++) {
            $category = Category::create([
                'name'        => $faker->name(),
                'description' => $faker->paragraph(),
            ]);

            for ($j = 1; $j <= 5; $j++) {
                $childCategory = $category->childCategories()->create([
                    'name'        => $faker->sentence(2),
                    'description' => $faker->paragraph(),
                ]);

                for ($k = 1; $k <= 5; $k++) {
                    $childCategory->childCategories()->create([
                        'name'        => $faker->sentence(3),
                        'description' => $faker->paragraph(),
                    ]);
                }
            }
        }
    }
}
