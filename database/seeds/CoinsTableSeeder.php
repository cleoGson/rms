<?php

use Illuminate\Database\Seeder;
use App\Model\Coin;
use Faker\Factory as Faker;
class CoinsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $statuses = ['Godson', 'Yahaya', 'Nelson','Masanja','Mtemela'];
        foreach (range(1, 10000) as $index) {
            DB::table('coins')->insert([
                'name' => $statuses[shuffle($statuses)],
                'year' => rand(1999, 2019),
                'price' => rand(10000, 500000),
            ]);
        }
    }
}
