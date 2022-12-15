<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RoleMenu extends Migration
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
            'menu_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id');

        // add foreign key
        $this->forge->addForeignKey('role_id', 'role', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('menu_id', 'menu', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('role_menu', true);
    }

    public function down()
    {
        // drop table
        $this->forge->dropTable('role_menu');
    }
}
