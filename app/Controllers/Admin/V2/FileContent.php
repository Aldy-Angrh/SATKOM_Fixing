<?php

namespace App\Controllers\Admin\V2;

use App\Controllers\BaseController;
use Hermawan\DataTables\DataTable;

class FileContent extends BaseController
{
    public $data = [
        'title' => 'File Content',
        'subtitle' => 'Daftar File Content',
        'url' => 'admin.v2.document-process',
        'primary_key' => 'id',
    ];

    protected function prepareDataTable($datatable)
    {
        return $datatable
            ->edit('status', function ($data) {
                return \App\Models\V2\FileContent::getStatusLabel($data->status);
            })
            ->add('action', function ($row) {
                $row = (array) $row;

                $actions = [
                    'show' => [
                        "url" => rbac_url("admin.v2.file-content.show", $row['id']),
                        'icon' => 'fa fa-eye',
                        'label' => 'Lihat',
                        'class' => 'btn btn-primary btn-sm dtbl-modal',
                    ],
                'show.edit' => [
                    "url" => rbac_url("admin.v2.file-content.show.edit", $row['id']),
                    'icon' => 'fa fa-eye',
                    'label' => 'Lihat',
                    'class' => 'btn btn-primary btn-sm dtbl-modal',
                ],
                ];

                return $this->generateActionTable($actions);
            });
    }

    

    public function process($id)
    {
        $model = new \App\Models\V2\FileContent();
        $data = $model->find($id);

        if (!$data) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'File content tidak dapat diproses',
            ])->setStatusCode(404);
        }



        try {
            if ($data['status'] == 2){
                $data['status'] = 0;
                $data['send_date'] = null;
                $data['result_code'] = 0;
                $data['result_desc'] = 'Success';
                $data['order_id'] = null;
            }else if($data['status'] == 5){
                $data['status'] = 3;
                $data['send_date_1'] = null;
                $data['result_code'] = 0;
                $data['result_desc'] = 'Success';
                $data['order_id_1'] = null;
            }

            if (!$model->update($data['id'], $data)) {
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

    public function datatable($id)
    {
        $model = new \App\Models\V2\FileContent();

        $query = $model
            ->select(implode(",", [
                'id',
                'file_id',
                'email_peserta',
                'email_penandatangan',
                'action',
                'sign_date',
                'status',
            ]))
            ->where('file_id', $id);

        $datatable = DataTable::of($query)->addNumbering();

        $datatable = $this->prepareDataTable($datatable);

        return $datatable->toJson();
    }

    function prepareDataShowModal($data)
    {
        $data['status'] = \App\Models\V2\FileContent::getStatusLabel($data['status']);
        // remove unnecessary data
        // unset($data['id']);
        // unset($data['file_id']);
        return $data;
    }

    public function show($id)
    {
        $model = new \App\Models\V2\FileContent();

        $data = $model->where('id', $id)->first();

        if (!$data) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ]);
        }

        // label status

        // if has modal param, return modal view
        if ($this->request->getGet('modal')) {
            $data = $this->prepareDataShowModal($data);
            return $this->response->setJSON([
                'status' => true,
                'data' => [
                    'title' => 'Detail Log',
                    'content' => view('admin/history/v2/file-content/show-modal', [
                        'data' => $data,
                    ]),
                ],
            ])->setStatusCode(200);
        }

        return view('admin/history/v2/show-content', [
            'data' => $data,
            'title' => 'Detail Log',
            'subtitle' => 'Detail Log',
            'url' => 'admin.v2.history',
        ]);
    }

    public function showedit($id)
    {

        $model = new \App\Models\V2\FileContent();

        $data = $model->where('id', $id)->first();

        if (!$data) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ]);
        }

        // label status

        // if has modal param, return modal view
        if ($this->request->getGet('modal')) {
            $data = $this->prepareDataShowModal($data);
            return $this->response->setJSON([
                'status' => true,
                'data' => [
                    'title' => 'Detail Log',
                    'content' => view('admin/history/v2/file-content/show-modal-edit', [
                        'data' => $data,
                    ]),
                    'url' => rbac_url("admin.v2.history.editdata"),$data["id"],
                ],
            ])->setStatusCode(200);
        }

        $data['status_label'] = \App\Models\V2\FileContent::getStatus($data['status']);
        
        return $this->response->setJSON([
            'status' => true,
            'data' => $data,
        ])->setStatusCode(200);
    }

    protected function generateActionTable($actions)
    {
        $html = '<div class="btn-group">';
        foreach ($actions as $action) {
            if (is_array($action['url'])) {
                $can_perform = true;
                $data = [];
                foreach ($action['url'] as $key => $value) {
                    if (!$value) {
                        $can_perform = false;
                        break;
                    }
                    $data[] = "data-url-{$key}={$action['url'][$key]}";
                }

                if (!$can_perform) {
                    continue;
                }

                $data = implode(' ', $data);
                $html .= "<button {$data} class='{$action['class']}'><i class='{$action['icon']}'></i></button>";
            } else {
                if ($action['url']) {
                    $data = "data-url={$action['url']}";
                    $html .= "<button {$data} class='{$action['class']}'><i class='{$action['icon']}'></i></button>";
                }
            }
        }
        $html .= '</div>';

        return $html;
    }
}
