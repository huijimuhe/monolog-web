<?php

use Faker\Factory as Faker;

class UserTableSeeder extends Seeder {

    public function run() {
        $faker = Faker::create();

        foreach (range(1, 500) as $index) {
            User::create([
                'name' => $faker->userName(),
                'salt' => $faker->password(),
                'password' => Hash::make('admin'),
                'remember_token' => $faker->md5(),
                'is_banned' => 0,
                'is_r' => 1,
                'sina_token' => $faker->md5(),
                'weixin_token' => $faker->md5(),
                'qq_token' => $faker->md5(),
                'created_at' => $faker->dateTime(),
                'updated_at' => $faker->dateTime(),
            ]);
        }
    }

}
