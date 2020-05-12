<?php

use Phinx\Seed\AbstractSeed;

class UserTableSeeder extends AbstractSeed
{
    public function run($data = [])
    {
        $faker = Faker\Factory::create();
        for ($i = 0; $i < 5; $i++) {
            $data[] = [
                'email' => $faker->email,
                'password' => password_hash('123456', PASSWORD_DEFAULT)
            ];
        }
        $this->table('users')->insert($data)->saveData();
    }
}
