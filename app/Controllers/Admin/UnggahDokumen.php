<?php

namespace App\Controllers\Admin;

use App\Controllers\MyController;

class UnggahDokumen extends MyController
{

    protected $model      = '\App\Models\FileUpload';
    protected $viewFolder = 'admin/unggah-dokumen/';

    protected $data = [
        'title'       => 'Unggah Dokumen',
        'subtitle'    => 'Unggah dokumen yang akan ditandatangani',
        'url'         => 'admin.unggah-dokumen',
        'primary_key' => 'id',
    ];

    protected $fields = [];


    public function index()
    {
        return view($this->viewFolder . '/index', $this->data);
    }

    public function store()
    {
        return $this->respond([
            'status'  => true,
            'message' => 'Data berhasil disimpan | Dummy',
        ], 201);
    }


    private function respond($data, $status = 200)
    {
        return $this->response->setStatusCode($status)->setJSON($data);
    }
}
