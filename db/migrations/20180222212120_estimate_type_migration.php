<?php


use Phinx\Migration\AbstractMigration;

class EstimateTypeMigration extends AbstractMigration
{
    public function up()
    {
        $estimateType = $this->table('estimate_type');
        $estimateType->addColumn('name', 'string')
                     ->addColumn('image', 'string')
                     ->addColumn('active', 'integer', ['default' => 0])
                     ->addIndex('name')
                     ->save();
    }
}
