<?php

namespace App\Models;

use CodeIgniter\Model;

 class FileContent extends Model {
    protected $table = 'file_contents';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['file_id', 'email_peserta', 'nama_peserta','email_penandatangan','nama_penandatangan','action','lower_left_x','lower_left_y','upper_right_x','upper_right_y','page','sign_date','send_date','status','content_line','description','baris','pos', 'file_name', 'order_id','result_code','result_desc', 'file_name_done'];
   protected $useTimestamps = true;

  public function scenario()
  {
    return [
      'update' => [
        'email_peserta' => 'required|valid_email',
        'email_penandatangan' => 'required|valid_email',
      ],
    ];
  }
 }


