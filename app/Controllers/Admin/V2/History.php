<?php

namespace App\Controllers\Admin\V2;

use App\Controllers\MyController;
use CodeIgniter\CLI\CLI;

class History extends MyController
{
    protected $model = '\App\Models\V2\FileUpload';
    protected $viewFolder = 'admin/history/v2/';

    protected $data = [
        'title' => 'History V2',
        'subtitle' => 'Daftar History V2',
        'url' => 'admin.v2.history',
        'url_update' => 'admin.v2.history.update',
        'primary_key' => 'id',
    ];

    protected $fields = [
        'file_contents.id' => [
            'label' => 'ID',
            'show' => false,
        ],
        'file_upload.file_name as file_csv' => [
            'label' => 'Nama File',
            'show' => true,
        ],
        'file_contents.file_name' => [
            'label' => 'Dokumen ditandatangan',
            'show' => true,
        ],

        'file_contents.email_peserta' => [
            'label' => 'Email Peserta',
            'show' => true,
        ],
        'file_contents.nama_peserta' => [
            'label' => 'Nama Peserta',
            'show' => true,
        ],
        'file_contents.send_date' => [
            'label' => 'Dikirim pada',
            'show' => true,
        ],
        'file_contents.sign_date' => [
            'label' => 'Disign pada',
            'show' => true,
        ],

        'file_contents.email_penandatangan' => [
            'label' => 'Email Penandatangan',
            'show' => true,
        ],
        'file_contents.nama_penandatangan' => [
            'label' => 'Nama Penandatangan',
            'show' => true,
        ],
        
        'file_contents.send_date_1' => [
            'label' => 'Dikirim penandatangan pada',
            'show' => true,
        ],
        'file_contents.sign_date_1' => [
            'label' => 'Disign penandatangan pada',
            'show' => true,
        ],

        'file_contents.status' => [
            'label' => 'Status',
            'show' => true,
        ],
   
        'file_contents.result_code' => [
            'label' => 'Result Code',
            'show' => true,
        ],
        'file_contents.result_desc' => [
            'label' => 'Result Desc',
            'show' => true,
        ],
    ];

    function __construct()
    {
        $query = new $this->model;
        $this->datatable = $query->select(implode(',', array_keys($this->fields)))->join('file_contents', 'file_contents.file_id = file_upload.id', 'right')->orderBy('file_contents.created_at', 'DESC');
    }


    private function myCustomDataTableFilter($query)
    {
        // custom filter with cfilter
        $filters = $this->request->getGet('cfilter');

        if (isset($filters['file_name']) && $filters['file_name']) {
            $query->like('file_contents.file_name', $filters['file_name']);
        }

        if (isset($filters['file_csv']) && $filters['file_csv']
        ) {
            $query->like('file_upload.file_name', $filters['file_csv']);
        }

        if (isset($filters['email_peserta']) && $filters['email_peserta']) {
            $query->like('file_contents.email_peserta', $filters['email_peserta']);
        }

        if (isset($filters['nama_peserta']) && $filters['nama_peserta']
        ) {
            $query->like('file_contents.nama_peserta', $filters['nama_peserta']);
        }

        if (isset($filters['email_penandatangan']) && $filters['email_penandatangan']) {
            $query->like('file_contents.email_penandatangan', $filters['email_penandatangan']);
        }

        if (isset($filters['nama_penandatangan']) && $filters['nama_penandatangan']) {
            $query->like('file_contents.nama_penandatangan', $filters['nama_penandatangan']);
        }

        if (isset($filters['status']) && is_string($filters['status']) && $filters['status'] !== '') {
            $query->where('file_contents.status', $filters['status']);
        }


        if (isset($filters['send_date']) && $filters['send_date']) {
            $date = explode(' - ', $filters['send_date']);
            $query->where('file_contents.send_date >=', date('Y-m-d', strtotime($date[0])));
            $query->where('file_contents.send_date <=', date('Y-m-d', strtotime($date[1])));
        }

        if (isset($filters['sign_date']) && $filters['sign_date']) {
            $date = explode(' - ', $filters['sign_date']);
            $query->where('file_contents.sign_date >=', date('Y-m-d', strtotime($date[0])));
            $query->where('file_contents.sign_date <=', date('Y-m-d', strtotime($date[1])));
        }


        if (isset($filters['penandatangan_send_date']) && $filters['penandatangan_send_date']) {
            $date = explode(' - ', $filters['penandatangan_send_date']);
            $query->where('file_contents.send_date_1 >=', date('Y-m-d', strtotime($date[0])));
            $query->where('file_contents.send_date_1 <=', date('Y-m-d', strtotime($date[1])));
        }

        if (isset($filters['penandatangan_sign_date']) && $filters['penandatangan_sign_date']) {
            $date = explode(' - ', $filters['sign_date']);
            $query->where('file_contents.sign_date_1 >=', date('Y-m-d', strtotime($date[0])));
            $query->where('file_contents.sign_date_1 <=', date('Y-m-d', strtotime($date[1])));
        }

        if (isset($filters['result_code']) && $filters['result_code']) {
            $query->like('file_contents.result_code', $filters['result_code']);
        }

        if (isset($filters['result_desc']) && $filters['result_desc']) {
            $query->like('file_contents.result_desc', $filters['result_desc']);
        }

        // default orderable
        $query->orderBy('file_upload.created_at', 'desc')->orderBy('file_contents.updated_at', 'desc');

        return $query;
    }

    public function editData()
    {
        $model = new \App\Models\V2\FileContent();
        $data = [];
        $request = $this->request->getRawInput();
        log_message('info', $request['email_penandatangan']);
        foreach (array_keys($model->scenario()['update']) as $field) {
            if (isset($request[$field])) {
                $data[$field] = $request[$field];
            }
        }

        $dataFileContent = $model->find($data['id']);

        if (!$dataFileContent) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'File content tidak dapat diproses',
            ])->setStatusCode(404);
        }

        try {
            if ($dataFileContent['status'] == 2){
                $dataFileContent['email_peserta'] = $data["email_peserta"];
                $dataFileContent['send_date'] = null;
                $dataFileContent['status'] = 0;
            }else if($dataFileContent['status'] == 5){
                $dataFileContent['email_penandatangan'] = $data["email_penandatangan"];
                $dataFileContent['send_date_1'] = null;
                $dataFileContent['status'] = 3;
            }
            
            
            $dataFileContent['result_code'] = '';
            $dataFileContent['result_desc'] = '';
           
            

            if (!$model->update($data['id'], $dataFileContent)) {
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Gagal memproses file content',
                ])->setStatusCode(400);
            }

            return $this->response->setJSON([
                'status' => true,
                'message' => 'File content berhasil diproses',
            ])->setStatusCode(200);
        } catch (\Throwable $th) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Gagal memproses file content : ' . $th->getMessage(),
            ])->setStatusCode(500);
        }
    }

    protected function prepareDataTable($datatable)
    {
        $model = new $this->model;

        return $datatable
            ->filter(function ($query) {
                return $this->myCustomDataTableFilter($query);
            })
            ->edit('email_peserta', function ($row) use ($model) {
                return $row->email_peserta == null ? '-' : $row->email_peserta;
            })
            ->edit('email_penandatangan', function ($row) use ($model) {
                return $row->email_penandatangan == null ? '-' : $row->email_penandatangan;
            })

            ->add('action', function ($row) {
                $url = $this->data['url'];

                // $actions = [
                //     'edit' => [
                //         "url" => rbac_url("$url.show", $row->id),
                //         'icon' => 'fa fa-eye',
                //         'label' => 'Lihat',
                //         'class' => 'btn btn-primary btn-sm dtbl-redirect',
                //     ],
                // ];

                $actions = [
                    'show' => [
                        "url" => rbac_url("admin.v2.file-content.show", $row->id),
                        'icon' => 'fa fa-eye',
                        'label' => 'Lihat',
                        'class' => 'btn btn-primary btn-sm dtbl-redirect',
                    ],
                ];

                if ((($row->status === \App\Models\V2\FileContent::STATUS_SUCCESS_SEND_DOCUMENT_PEKERJA || $row->status === \App\Models\V2\FileContent::STATUS_SUCCESS_SEND_DOCUMENT_PENANDATANGAN) && $row->result_code === 'SB001')) {
                    $actions['showedit'] = [
                        "url" => rbac_url("admin.v2.file-content.showedit", $row->id),
                        'icon' => 'fa fa-edit',
                        'label' => 'Lihat',
                        'class' => 'btn btn-sm btn-warning dtbl-edit dtbl-post-action',
                    ];
                }

                if (($row->status === \App\Models\V2\FileContent::STATUS_SUCCESS_SEND_DOCUMENT_PEKERJA || $row->status === \App\Models\V2\FileContent::STATUS_SUCCESS_SEND_DOCUMENT_PENANDATANGAN)&& $row->result_code === 'BP-003') {
                    $actions['process'] = [
                        "url" => rbac_url("admin.v2.file-content.process", $row->id),
                        'icon' => 'fa fa-check',
                        'label' => 'Proses',
                        'class' => 'btn btn-success btn-sm dtbl-post-action-exp',
                    ];
                }

                return $this->generateActionTable($actions);
            })
            ->edit('status', function ($row) use ($model) {
                return (new $model)::getStatusLabel($row->status);
            });
    }

    protected function prepareDataShow($data)
    {
        $data['status_label'] = (new $this->model)::getStatusLabel($data['status']);
        return $data;
    }

    public function export()
    {
        $export = new \App\Exports\FileUploadExport();
        return $export->download();
    }

    public function status()
    {
        $model = new $this->model;
        $status = $model::getStatuses();
        return $this->response->setJSON($status);
    }
}
