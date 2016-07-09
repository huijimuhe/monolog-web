<?php

use Faker\Factory as Faker;

class FollowerTableSeeder extends Seeder {

    public function run() {
        $faker = Faker::create();
        $users = User::lists('id');

        foreach (range(1, 50) as $index) {
            Follower::create([
                'user_id' => $faker->randomElement($users),
                'from_user_id' => $faker->randomElement($users),
            ]);
        }
    }

}
