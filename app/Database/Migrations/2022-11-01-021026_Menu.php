<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Menu extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'controller' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'default'    => '#',
            ],
            'action' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'default'    => 'index',
            ],
            'icon' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'order' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => NULL,
            ],
            'parent_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => NULL,
                'unsigned'   => true,
            ],
        ]);

        // primary key
        $this->forge->addPrimaryKey('id', true);

        // add foreign key constraint
        $this->forge->addForeignKey('parent_id', 'menu', 'id', 'CASCADE', 'CASCADE');

        // create table
        $this->forge->createTable('menu', true);
    }

    public function down()
    {
        // drop table
        $this->forge->dropTable('menu');
    }
}
