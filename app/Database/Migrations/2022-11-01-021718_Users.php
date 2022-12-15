<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
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
                'constraint' => '255',
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'unique'     => true,
            ],
            'phone_number' => [
                'type'       => 'VARCHAR',
                'constraint' => '25',
                'unique'     => true,
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'unique'     => true,
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'role_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'photo_url' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'default'    => NULL,
            ],
            'login_token' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'default'    => NULL,
            ],
            'is_active' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        // add foreign key
        $this->forge->addForeignKey('role_id', 'role', 'id', 'CASCADE', 'CASCADE');

        // create table
        $this->forge->createTable('users', true);
    }

    public function down()
    {
        // drop table
        $this->forge->dropTable('users');
    }
}
