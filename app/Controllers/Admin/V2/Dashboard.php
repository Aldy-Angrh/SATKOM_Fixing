<?php

namespace App\Controllers\Admin\V2;


use App\Controllers\MyController;

class Dashboard extends MyController
{
  protected $model = '\App\Models\V2\FileUpload';
  protected $viewFolder = 'admin/dashboard/v2';

  protected $data = [
    'title' => 'Dashboard V2',
    'subtitle' => 'Dashboard V2',
    'url' => 'admin.v2.dashboard',
    'primary_key' => 'id',
  ];

  protected $fields = [
    'file_upload.id' => [
      'label' => 'ID',
      'show' => false,
    ],
    'file_upload.file_name' => [
      'label' => 'Dokumen',
      'show' => true,
    ],
    'file_upload.deskripsi' => [
      'label' => 'Deskripsi',
      'show' => true,
    ],
    'file_upload.created_at' => [
      'label' => 'Dibuat pada',
      'show' => true,
    ],
    'file_upload.updated_at' => [
      'label' => 'Diubah pada',
      'show' => true,
    ],
  ];

  function __construct()
  {
    $query = new $this->model;
    $this->datatable = $query->select(implode(',', array_keys($this->fields)));
  }

  public function index()
  {
    $model = new $this->model;
    $data = array_merge($this->data, [
      'file_count' => $model->getCountOfFile(),
      'file_success_count' => $model->getCountOfSuccessFile(),
      'file_failed_count' => $model->getCountOfFailedFile(),
      'fields' => $this->fields,
    ]);

    return view("$this->viewFolder/index", $data);
  }


  protected function prepareDataTable($datatable)
  {
    $model = new $this->model;

    return $datatable
      ->edit('status', function ($row) use ($model) {
        return $model::getStatusLabel($row->status);
      })
      ->edit('email_peserta', function ($row) use ($model) {
        return $row->email_peserta == null ? '<i style="color:red">(null)</i>' : $row->email_peserta;
      })
      ->edit('email_penandatangan', function ($row) use ($model) {
          return $row->email_penandatangan == null ? '<i style="color:red">(null)</i>' : $row->email_penandatangan;
      })
      ->edit('nama_peserta', function ($row) use ($model) {
        return $row->nama_peserta == null ? '<i style="color:red">(null)</i>' : $row->nama_peserta;
      })
      ->add('jumlah_sukses', function ($row) use ($model) {
        return $model::getCountOfSuccessContent($row->id);
      })
      ->add('jumlah_gagal', function ($row) use ($model) {
        return $model::getCountOfFailedContent($row->id);
      })
      ;
  }
}
