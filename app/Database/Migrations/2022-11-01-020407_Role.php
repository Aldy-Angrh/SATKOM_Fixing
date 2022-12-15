<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Role extends Migration
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
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '255'
            ]
        ]);
        // primary key
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('role', true);
    }

    public function down()
    {
        // drop table
        $this->forge->dropTable('role');
    }
}
