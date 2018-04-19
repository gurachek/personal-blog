<?php


use Phinx\Migration\AbstractMigration;

class PostTagMigration extends AbstractMigration
{
    public function up()
    {
        $post_tag = $this->table('post_tag');
        $post_tag->addColumn('post_id', 'integer')
                 ->addColumn('tag_id', 'integer')
                 ->save();
    }
}
