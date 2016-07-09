<?php

use Faker\Factory as Faker;

class GuessTableSeeder extends Seeder {

    public function run() {
        $faker = Faker::create();
        $users = User::lists('id');
        $statues = Statue::lists('id');
        
        foreach (range(1, 50) as $index) {
            Guess::create([
                'from_user_id' => $faker->randomElement($users),
                'user_id' => $faker->randomElement($users),
                'statue_id' => $faker->randomElement($statues),
                'result' => $faker->randomElement([0, 1]),
                'is_readed' => $faker->randomElement([0, 1]),
                'created_at' => $faker->dateTime(),
                'updated_at' => $faker->dateTime(),
            ]);
        }
    }

}
