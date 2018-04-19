<?php


use Phinx\Migration\AbstractMigration;

class EstimateMigration extends AbstractMigration
{
    public function up()
    {
        $estimate = $this->table('estimate');
        $estimate->addColumn('user_id', 'integer')
                 ->addColumn('estimate_id', 'integer')
                 ->addColumn('time', 'string', ['default' => 'NULL'])
                 ->addColumn('post_id', 'integer')
                 ->save();
    }
}
