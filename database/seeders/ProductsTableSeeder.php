<?php

namespace Database\Seeders;

use Faker\Generator;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Container\Container;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Container::getInstance()->make(Generator::class);

        for($i = 1; $i <= 20; $i++) {
            $product         = new Product;
            $product->name   = $faker->sentence($nbWords = 6, $variableNbWords = true);
            $product->slug   = 'product-' . $i;
            $product->description = $faker->paragraphs($nb = 3, $asText = true);
            $product->price = $faker->numberBetween($min = 1000, $max = 6000);
            $product->order = 1;
            $product->status = 1;
            $product->save();
        }
    }
}
