<?php

use Faker\Factory as Faker;

class ReportTableSeeder extends Seeder {

    public function run() {
        $faker = Faker::create();
        $users = User::lists('id');
        $statues = Statue::lists('id');
        
        foreach (range(1, 50) as $index) {
            Report::create([
                'from_user_id' => $faker->randomElement($users),
                'statue_id' => $faker->randomElement($statues),
                'reason' => $faker->text($maxNbChars = 20),
                'isbanned' => $faker->randomElement([0, 1]),
            ]);
        }
    }

}
