<?php

use Phinx\Seed\AbstractSeed;

class NoteTableSeeder extends AbstractSeed
{
    public function getDependencies()
    {
        return [
            'AuthorTableSeeder'
        ];
    }

    public function run($data = [])
    {
        $sql = "SELECT id FROM authors ORDER BY RAND() LIMIT 1";
        $faker = Faker\Factory::create();
        for ($i = 0; $i < 50; $i++) {
            $data[] = [
                'title' => $faker->text(40),
                'content' => $faker->text(),
                'author_id' => (int)$this->fetchRow($sql)['id'],
                'created_at' => $date = $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
                'updated_at' => $date
            ];
        }
        $this->table('notes')->insert($data)->saveData();
    }
}
