<?php

namespace App\Controllers\Rbac;

use App\Controllers\MyController;

class Menu extends MyController
{

    /**
     * @var \CodeIgniter\Model
     * Model of this controller
     */
    protected $model = '\App\Models\Rbac\MenuModel';

    /**
     * @var string
     * Folder of view
     */
    protected $viewFolder = 'rbac/menu/';

    /**
     * @var array
     * Data to be passed to view 
     * must contain title, subtitle, url, primary_key
     */
    protected $data = [
        'title' => 'Menu',
        'subtitle' => 'Daftar Menu',
        'url' => 'admin.rbac.menu',
        'primary_key' => 'id',
    ];



    /**
     * @var array
     * Fields of table
     */
    protected $fields = [
        'id' => [
            'label' => 'Id',
            'show' => false,
        ],
        'name' => [
            'label' => 'Nama',
            'show' => true,
        ],
        'controller' => [
            'label' => 'Controller',
            'show' => true,
        ],
        'action' => [
            'label' => 'Action',
            'show' => true,
        ],
        'icon' => [
            'label' => 'Icon',
            'show' => true,
        ],
        'order' => [
            'label' => 'Order',
            'show' => true,
        ],
        'parent_id' => [
            'label' => 'Parent',
            'show' => true,
        ],
    ];

    protected function hookBeforeAction($data)
    {
        // convert parent_id '' to null
        if (isset($data['parent_id']) && $data['parent_id'] == '') {
            $data['parent_id'] = null;
        }

        return $data;
    }

    protected function prepareDataStore($data)
    {
        return $this->hookBeforeAction($data);
    }

    protected function prepareDataUpdate($data)
    {
        return $this->hookBeforeAction($data);
    }


    public function orderable()
    {
        // return orderable menu
        $model = new $this->model;
        $menu = $model->getTree();

        // to html ol li
        $html = $model->buildOrderableHtml($menu);
        return $this->response->setJSON([
            'html' => $html,
        ]);
    }

    public function updateOrder()
    {
        try {
            $model = new $this->model;
            $data = $this->request->getPost('data');
            if ($data == '') {
                throw new \Exception('Perubahan tidak ditemukan');
            }

            // decode json
            $data = json_decode($data, true);

            // failed to decode json
            if ($data == null) {
                throw new \Exception('Format data tidak valid');
            }
            $model->updateOrderAndParent($data);
            return $this->response->setJSON([
                'status' => true,
                'message' => 'Berhasil menyimpan urutan menu',
            ]);
        } catch (\Throwable $th) {
            $msg = '';
            if (ENVIRONMENT == 'development') {
                $msg = $th->getMessage();
            } else {
                $msg = 'Terjadi kesalahan';
            }
            return $this->response->setJSON([
                'status' => false,
                'message' => $msg,
            ]);
        }
    }
}
