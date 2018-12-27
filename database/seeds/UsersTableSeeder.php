<?php

use Illuminate\Database\Seeder;
use App\Entity\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run():void
    {
        factory(User::class, 10)->create();
    }
}
