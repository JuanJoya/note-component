<?php

use Phinx\Migration\AbstractMigration;

class CreateNotesTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('notes', ['collation' => 'utf8_spanish_ci', 'signed' => false]);
        $table
            ->addColumn('title', 'string', ['limit' => 50, 'null' => false])
            ->addColumn('content', 'string', ['limit' => 200, 'null' => false])
            ->addColumn('author_id', 'integer', ['signed' => false, 'null' => false])
            ->addColumn('created_at', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'datetime', [
                'null' => false,
                'default' => 'CURRENT_TIMESTAMP',
                'update' => 'CURRENT_TIMESTAMP'
            ])
            ->addForeignKey('author_id', 'authors', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->create();
    }
}
