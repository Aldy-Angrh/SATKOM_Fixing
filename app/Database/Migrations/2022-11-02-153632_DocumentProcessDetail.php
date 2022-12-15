<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DocumentProcessDetail extends Migration
{
    public function up()
    {
        // create table from raw SQL
        $this->db->query('CREATE TABLE IF NOT EXISTS `document_process_detail` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `id_document` int(11) DEFAULT NULL,
          `email_penandatangan` varchar(100) DEFAULT NULL,
          `action` varchar(100) DEFAULT NULL,
          `lower_left_x` int(11) DEFAULT NULL,
          `lower_left_y` int(11) DEFAULT NULL,
          `upper_right_x` int(11) DEFAULT NULL,
          `upper_right_y` int(11) DEFAULT NULL,
          `page` int(11) DEFAULT NULL,
          `sign_date` timestamp NULL DEFAULT NULL,
          `send_date` datetime DEFAULT NULL,
          `status` int(11) DEFAULT NULL,
          `description` varchar(100) DEFAULT NULL,
          PRIMARY KEY (`id`),
          KEY `document_process_detail_FK` (`id_document`),
          CONSTRAINT `document_process_detail_FK` FOREIGN KEY (`id_document`) REFERENCES `document_process` (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;');
    }

    public function down()
    {
        // drop table
        $this->forge->dropTable('document_process_detail', true);
    }
}
