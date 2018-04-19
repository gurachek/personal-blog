<?php


use Phinx\Migration\AbstractMigration;

class PostsMigration extends AbstractMigration
{
    public function up()
    {
        $post = $this->table('post');
        $post->addColumn('title', 'string')
             ->addColumn('preview', 'text')
             ->addColumn('text', 'text')
             ->addColumn('user_id', 'integer')
             ->addColumn('category_id', 'integer')
             ->addColumn('created', 'string', ['default' => 'NULL'])
             ->addColumn('updated', 'string', ['default' => 'NULL'])
             ->addColumn('image', 'string')
             ->addColumn('active', 'integer')
             ->save();

    }

    public function down()
    {
        /* Nothing to code yet */ 
    }
}
