<?php

use Illuminate\Database\Seeder;
use App\Message;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        factory(App\User::class, 50)->create();
        factory(App\Message::class, 100)->create();
    }
}
