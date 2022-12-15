<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DocumentProcess extends Migration
{
    public function up()
    {
        // create table from raw SQL
        $this->db->query('CREATE TABLE IF NOT EXISTS `document_process` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `email_file_owner` varchar(100) DEFAULT NULL,
          `status` int(11) DEFAULT NULL,
          `file_id` int(11) DEFAULT NULL,
          `name_owner` varchar(100) DEFAULT NULL,
          `created_at` datetime DEFAULT NULL,
          `created_by` varchar(100) DEFAULT NULL,
          `updated_at` datetime DEFAULT NULL,
          `updated_by` varchar(100) DEFAULT NULL,
          `deleted_at` datetime DEFAULT NULL,
          `deleted_by` varchar(100) DEFAULT NULL,
          `description` varchar(100) DEFAULT NULL,
          `data` text,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;');
    }

    public function down()
    {
        // drop table
        $this->forge->dropTable('document_process', true);
    }
}
