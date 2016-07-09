<?php

use Faker\Factory as Faker;

class ProfileTableSeeder extends Seeder {

    public function run() {
        $faker = Faker::create();
        $users = User::lists('id'); 

        foreach ($users as $uid) {
            Profile::create([
                'user_id' => $uid,
                'gender' => $faker->randomElement(['m', 'f']),
                'avatar' => '-1',
            ]);
        }
    }

}
