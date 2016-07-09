<?php

use Faker\Factory as Faker;

class StatueTableSeeder extends Seeder {

    public function run() {
        $faker = Faker::create();
        $users = User::lists('id'); 

        foreach (range(1, 500) as $index) {
            Statue::create([ 
                'text' => $faker->text($maxNbChars = 120),
                'user_id' => $faker->randomElement($users), 
                'isbanned' => 0, 
                'created_at' => $faker->dateTime(),
                'updated_at' => $faker->dateTime(),
            ]);
        }
    }

}
