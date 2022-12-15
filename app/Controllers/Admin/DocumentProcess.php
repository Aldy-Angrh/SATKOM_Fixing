<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use Hermawan\DataTables\DataTable;

class DocumentProcess extends BaseController
{
    public $data = [
        'title' => 'Document Process',
        'subtitle' => 'Daftar Document Process',
        'url' => 'admin.document-process',
        'primary_key' => 'id',
    ];

    protected function prepareDataTable($datatable)
    {
        return $datatable
            ->edit('status', function ($data) {
                return \App\Models\DocumentProcess::getStatusLabel($data->status);
            })
            ->add('action', function ($row) {
                $row = (array) $row;

                $actions = [
                    'show' => [
                        "url" => rbac_url("admin.document-process.show", $row['id']),
                        'icon' => 'fa fa-eye',
                        'label' => 'Lihat',
                        'class' => 'btn btn-primary btn-sm dtbl-modal',
                    ],
                    'detail' => [
                        "url" => rbac_url("admin.document-process.detail", $row['id']),
                        'icon' => 'fa fa-gear',
                        'label' => 'Lihat',
                        'class' => 'btn btn-success btn-sm dtbl-modal',
                    ],
                ];

                return $this->generateActionTable($actions);
            });
    }

    public function datatable($id)
    {
        $model = new \App\Models\DocumentProcess();

        $query = $model
            ->select('id, email_file_owner, status, file_id, name_owner, created_at, created_by, updated_at, updated_by, deleted_at, deleted_by, description, data')
            ->where('file_id', $id);

        $datatable = DataTable::of($query)->addNumbering();

        $datatable = $this->prepareDataTable($datatable);

        return $datatable->toJson();
    }

    public function show($id)
    {
        $model = new \App\Models\DocumentProcess();

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
            $data['status_label'] = \App\Models\DocumentProcess::getStatusLabel($data['status']);
            return $this->response->setJSON([
                'status' => true,
                'data' => [
                    'title' => 'Detail Document Process',
                    'content' => view('admin/document-process/show-modal', [
                        'data' => $data,
                    ]),
                ],
            ])->setStatusCode(200);
        }

        $data['status_label'] = \App\Models\DocumentProcess::getStatus($data['status']);
        return $this->response->setJSON([
            'status' => true,
            'data' => $data,
        ])->setStatusCode(200);
    }

    public function detail($id)
    {
        $model = new \App\Models\DocumentProcessDetail();

        $data = $model
            ->select('
            email_penandatangan,
            action,
            lower_left_x,
            lower_left_y,
            upper_right_x,
            upper_right_y,
            page,
            sign_date,
            send_date,
            status,
            description')
            ->where('id_document', $id)->findAll();

        // if has modal param, return modal view
        if ($this->request->getGet('modal')) {
            foreach ($data as $key => $value) {
                $data[$key]['status'] = \App\Models\DocumentProcessDetail::getStatusLabel($value['status']);
            }
            return $this->response->setJSON([
                'status' => true,
                'data' => [
                    'title' => 'Detail Document Process',
                    'content' => view('admin/document-process/detail-modal', [
                        'data' => $data,
                    ]),
                ],
            ])->setStatusCode(200);
        }
        foreach ($data as $key => $value) {
            $data[$key]['status'] = \App\Models\DocumentProcessDetail::getStatus($value['status']);
        }

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
