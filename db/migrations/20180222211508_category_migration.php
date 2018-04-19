<?php


use Phinx\Migration\AbstractMigration;

class CategoryMigration extends AbstractMigration
{
    public function up()
    {
        $category = $this->table('category');
        $category->addColumn('name', 'string')
                 ->addColumn('parent_id', 'integer', ['default' => 0])
                 ->addColumn('about', 'text')
                 ->addColumn('image', 'string')
                 ->addColumn('visible', 'integer', ['default' => 0])
                 ->addIndex('name')
                 ->save();
    }
}
