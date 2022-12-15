<?php

namespace App\Controllers\Admin;

use App\Controllers\MyController;
use Hermawan\DataTables\DataTable;

class History extends MyController
{
    protected $model = '\App\Models\FileUpload';
    protected $viewFolder = 'admin/history/';

    protected $data = [
        'title' => 'History',
        'subtitle' => 'Daftar History',
        'url' => 'admin.history',
        'primary_key' => 'id',
    ];

    protected $fields = [
        'id' => [
            'label' => 'ID',
            'show' => false,
        ],
        'file_name' => [
            'label' => 'Dokumen',
            'show' => false,
        ],
        'deskripsi' => [
            'label' => 'Deskripsi',
            'show' => true,
        ],
        'status' => [
            'label' => 'Status',
            'show' => true,
        ],
        'created_at' => [
            'label' => 'Dibuat pada',
            'show' => true,
        ],
        'updated_at' => [
            'label' => 'Diubah pada',
            'show' => true,
        ],
    ];

    protected function prepareDataTable($datatable)
    {
        return $datatable
            ->filter(function ($query) {
                // custom filter with cfilter
                $filters = $this->request->getGet('cfilter');

                if (isset($filters['deskripsi']) && $filters['deskripsi']) {
                    $query->like('deskripsi', $filters['deskripsi']);
                }

                if (isset($filters['status']) && is_string($filters['status']) && $filters['status'] !== '') {
                    $query->where('status', $filters['status']);
                }

                if (isset($filters['created_at']) && $filters['created_at']) {
                    $date = explode(' - ', $filters['created_at']);
                    $query->where('created_at >=', date('Y-m-d', strtotime($date[0])));
                    $query->where('created_at <=', date('Y-m-d', strtotime($date[1])));
                }

                if (isset($filters['updated_at']) && $filters['updated_at']) {
                    $date = explode(' - ', $filters['updated_at']);
                    $query->where('updated_at >=', date('Y-m-d', strtotime($date[0])));
                    $query->where('updated_at <=', date('Y-m-d', strtotime($date[1])));
                }

                // default orderable
                $query->orderBy('created_at', 'desc')->orderBy('updated_at', 'desc');

                return $query;
            })
            ->add('jumlah_sukses', function ($row) {
                return \App\Models\FileUpload::getJumlahSukses($row->id);
            })
            ->add('jumlah_gagal', function ($row) {
                return \App\Models\FileUpload::getJumlahGagal($row->id);
            })
            ->add('action', function ($row) {
                $url = $this->data['url'];

                $actions = [
                    'edit' => [
                        "url" => rbac_url("$url.show", $row->id),
                        'icon' => 'fa fa-eye',
                        'label' => 'Lihat',
                        'class' => 'btn btn-primary btn-sm dtbl-redirect',
                    ],
                ];

                return $this->generateActionTable($actions);
            })
            ->edit('status', function ($row) {
                return \App\Models\FileUpload::getStatusLabelHtml($row->status);
            });
    }

    protected function prepareDataShow($data)
    {
        $data['status_label'] = \App\Models\FileUpload::getStatusLabelHtml($data['status']);
        return $data;
    }
}
