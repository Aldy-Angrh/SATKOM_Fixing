<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TokenPeruri extends Migration
{
    public function up()
    {
        // create table from raw SQL
        $this->db->query('CREATE TABLE IF NOT EXISTS `token_peruri` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `token` varchar(100) DEFAULT NULL,
          `expired_time` datetime DEFAULT NULL,
          `created_at` datetime DEFAULT NULL,
          `created_by` varchar(100) DEFAULT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;');
    }

    public function down()
    {
        // drop table
        $this->forge->dropTable('token_peruri', true);

    }
}
