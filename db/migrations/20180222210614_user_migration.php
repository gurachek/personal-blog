<?php


use Phinx\Migration\AbstractMigration;

class UserMigration extends AbstractMigration
{
    public function up()
    {
        $user = $this->table('user');
        $user->addColumn('name', 'string')
             ->addColumn('email', 'string')
             ->addColumn('about', 'text')
             ->addColumn('active', 'integer')
             ->addColumn('created', 'string', ['default' => 'NULL'])
             ->addColumn('image', 'string')
             ->addColumn('password', 'string')
             ->addIndex('name', 'email', ['unique' => true])
             ->save();
    }
}
