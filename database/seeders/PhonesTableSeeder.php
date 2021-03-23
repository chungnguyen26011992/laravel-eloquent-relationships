<?php

namespace Database\Seeders;

use App\Models\Phone;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Database\Seeder;

class PhonesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Container::getInstance()->make(Generator::class);

        for ($i = 0; $i < 10; $i++) {
            $phone = new Phone;
            $phone->number = $faker->e164PhoneNumber();
            $phone->user_id = ($i + 1);
            $phone->save();
        }
    }
}
