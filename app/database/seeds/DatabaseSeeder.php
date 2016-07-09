<?php

class DatabaseSeeder extends Seeder {

    //'catalogs', 'users',
    protected $tables = [ 'followers', 'guesses', 'profiles', 'statues', 'reports'];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Eloquent::unguard();
        foreach ($this->tables as $table) {
            DB::table($table)->truncate();
        }
        $this->call('UserTableSeeder');
        $this->call('ProfileTableSeeder');
        $this->call('StatueTableSeeder');
        $this->call('FollowerTableSeeder');
        $this->call('GuessTableSeeder');
        $this->call('ReportTableSeeder');
    }

}
