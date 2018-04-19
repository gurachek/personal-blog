<?php


use Phinx\Migration\AbstractMigration;

class TagMigration extends AbstractMigration
{
    public function up()
    {
        $tag = $this->table('tag');
        $tag->addColumn('name', 'string')
            ->addColumn('time', 'string', ['default' => 'NULL'])
            ->addIndex('name')
            ->save();
    }
}
