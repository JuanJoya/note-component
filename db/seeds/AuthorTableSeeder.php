<?php

use Illuminate\Support\Str;
use Phinx\Seed\AbstractSeed;

class AuthorTableSeeder extends AbstractSeed
{
    public function getDependencies()
    {
        return [
            'UserTableSeeder'
        ];
    }

    public function run($data = [])
    {
        $sql = "SELECT id FROM users ORDER BY RAND() LIMIT 1";
        $faker = Faker\Factory::create();
        for ($i = 0; $i < 10; $i++) {
            $data[] = [
                'username' => $username = $faker->userName,
                'slug' => Str::slug($username),
                'user_id' => (int)$this->fetchRow($sql)['id']
            ];
        }
        $this->table('authors')->insert($data)->saveData();
    }
}
