<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FileUpload extends Migration
{
    public function up()
    {
        // create table from raw SQL
        $this->db->query('CREATE TABLE IF NOT EXISTS `file_upload` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `file_name` varchar(100) NOT NULL,
          `status` int(11) DEFAULT NULL,
          `created_at` timestamp NULL DEFAULT NULL,
          `updated_at` timestamp NULL DEFAULT NULL,
          `deskripsi` varchar(100) DEFAULT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;');
    }

    public function down()
    {
        // drop table
        $this->forge->dropTable('file_upload', true);
    }
}
