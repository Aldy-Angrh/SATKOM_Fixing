<?php

namespace App\Models;

use CodeIgniter\Model;

 class FileUploadModel extends Model {
    protected $table = 'file_upload';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['file_name', 'status', 'deskripsi'];
   protected $useTimestamps = true;
 }
