<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Action extends Migration
{
    public function up()
    {
        // create table
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'controller_id' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
            'action_id' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
            'name' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
            'alias' => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
        ]);

        // primary key
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('action', true);
    }

    public function down()
    {
        // drop table
        $this->forge->dropTable('action');
    }
}
