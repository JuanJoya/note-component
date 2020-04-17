<?php

use Phinx\Migration\AbstractMigration;

class CreateAuthorsTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('authors', ['collation' => 'utf8_spanish_ci', 'signed' => false]);
        $table
            ->addColumn('username', 'string', ['limit' => 20, 'null' => false])
            ->addColumn('slug', 'string',  ['limit' => 40, 'null' => false])
            ->addColumn('user_id', 'integer', ['signed' => false, 'null' => false])
            ->addColumn('created_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'datetime',
                ['null' => false, 'default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'])
            ->addForeignKey('user_id', 'users', 'id', ['delete'=> 'CASCADE', 'update'=> 'CASCADE'])
            ->addIndex('slug', ['unique' => true])
            ->create();
    }
}
