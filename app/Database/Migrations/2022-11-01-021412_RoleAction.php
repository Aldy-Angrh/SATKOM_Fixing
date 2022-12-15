<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RoleAction extends Migration
{
    public function up()
    {

        // add fields
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'role_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'action_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
        ]);
        // primary key
        $this->forge->addPrimaryKey('id');
        // add foreign key
        $this->forge->addForeignKey('role_id', 'role', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('action_id', 'action', 'id', 'CASCADE', 'CASCADE');

        // create table
        $this->forge->createTable('role_action', true);
    }

    public function down()
    {
        // drop table
        $this->forge->dropTable('role_action');
    }
}
