<?php

namespace App\Controllers\Rbac;

use App\Controllers\MyController;
use Hermawan\DataTables\DataTable;

class Role extends MyController
{
    /**
     * @var \CodeIgniter\Model
     * Model of this controller
     */
    protected $model = '\App\Models\Rbac\RoleModel';
    protected $actionModel = '\App\Models\Rbac\ActionModel';

    /**
     * @var string
     * Folder of view
     */
    protected $viewFolder = 'rbac/role/';

    /**
     * @var array
     * Data to be passed to view 
     * must contain title, subtitle, url, primary_key
     */
    protected $data = [
        'title' => 'Role',
        'subtitle' => 'Daftar Role',
        'url' => 'admin.rbac.role',
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
    ];

    protected function prepareDataTable($datatable)
    {
        return $datatable
            ->add('action', function ($row) {
                $url = $this->data['url'];
                $actions = [
                    [
                        'class' => 'btn btn-sm btn-primary dtbl-edit',
                        'icon' => 'fa fa-edit',
                        'url' => [
                            'update' => rbac_url($url . '.update', $row->id),
                            'show' => rbac_url($url . '.show', $row->id),
                        ],
                    ],
                    [
                        'class' => 'btn btn-sm btn-danger dtbl-destroy',
                        'icon' => 'fa fa-trash',
                        'url' => rbac_url($url . '.destroy', $row->id),
                    ],
                    [
                        'class' => 'btn btn-sm btn-info  dtbl-redirect',
                        'icon' => 'fa fa-unlock-alt',
                        'url' => rbac_url($url . '.action', $row->id),
                    ],
                    [
                        'class' => 'btn btn-sm btn-success  dtbl-redirect',
                        'icon' => 'fa fa-gear',
                        'url' => rbac_url($url . '.menu', $row->id),
                    ],
                ];

                return $this->generateActionTable($actions);
            });
    }

    public function action($id)
    {
        $model = new $this->model;
        $actionModel = new $this->actionModel;
        $role = $model->find($id);
        $data = array_merge($this->data, [
            'subtitle' => 'Aksi Role ' . $role->name,
            'role' => $role,
        ]);

        // get all routes group by controller and http method
        $routes = \Config\Services::routes();
        $registeredControllers = $actionModel->getRegisteredControllers($routes);
        $routes = $actionModel->groupRoutes($routes);

        // update actions in database
        foreach ($registeredControllers as $i => $controller) {
            $data['registeredControllers'][$i]['controller'] = $controller;

            foreach ($routes as $route) {
                if ($route['controller'] == $controller) {
                    $data['registeredControllers'][$i]['actions'][] = $route;
                }
            }
        }


        $actionModel->saveAllActions($data['registeredControllers']);

        // get all actions from database
        $actionModel = new $this->actionModel;
        $data['registeredControllers'] = $actionModel->getActions($id);

        return view($this->viewFolder . 'action', $data);
    }

    public function updateAction($id)
    {
        try {
            $model = new $this->model;
            $role = $model->find($id);

            if (!$role) {
                // set header response
                $this->response->setStatusCode(404);
                // json response
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Role tidak ditemukan',
                ]);
            }

            $actionModel = new $this->actionModel;
            $actionModel->updateActions($id, $this->request->getPost('data'));

            // set header response
            $this->response->setStatusCode(200);
            // json response
            return $this->response->setJSON([
                'status' => true,
                'message' => 'Aksi berhasil diupdate',
            ]);
        } catch (\Throwable $th) {
            $msg = 'Terjadi kesalahan';
            if (ENVIRONMENT == 'development') {
                $msg = $th->getMessage();
            }

            // set header response
            $this->response->setStatusCode(500);
            // json response
            return $this->response->setJSON([
                'status' => false,
                'message' => $msg,
            ]);
        }
    }


    /**
     * View of role menu
     * @param int $id
     */
    public function menu($id)
    {
        $model = new $this->model;
        $role = $model->find($id);
        if (!$role) {
            // throw error
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        $data = array_merge($this->data, [
            'subtitle' => 'Menu Role untuk ' . $role->name,
            'role' => $role,
        ]);

        $menuModel = new \App\Models\Rbac\MenuModel();
        $data['menus'] = $menuModel->getTree($id);

        $roleMenuModel = new \App\Models\Rbac\RoleMenuModel();
        $data['roleMenus'] = $roleMenuModel->where('role_id', $id)->findAll();

        return view($this->viewFolder . 'menu', $data);
    }

    /**
     * Update role menu
     * @param $id
     * @return \CodeIgniter\HTTP\Response
     */
    public function saveMenu($id)
    {
        try {
            $model = new $this->model;
            $role = $model->find($id);
            if (!$role) {
                // set header response
                $this->response->setStatusCode(404);
                // json response
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Role tidak ditemukan',
                ]);
            }

            $roleMenuModel = new \App\Models\Rbac\RoleMenuModel();
            $data = $this->request->getPost('data');
            $success = false;

            if ($data) {
                $success = $roleMenuModel->updateRoleMenu($id, $data);
            }

            if ($success) {
                // set header response
                $this->response->setStatusCode(200);
                // response json
                return $this->response->setJSON([
                    'status' => true,
                    'message' => 'Menu berhasil disimpan',
                ]);
            } else {
                // set header response
                $this->response->setStatusCode(400);
                // response json
                return $this->response->setJSON([
                    'status' => false,
                    'message' => 'Menu gagal disimpan',
                ]);
            }
        } catch (\Throwable $th) {
            $msg = "Terjadi kesalahan";

            if (ENVIRONMENT == 'development') {
                $msg = $th->getMessage() . '. Line ' . $th->getLine() . ', ' . $th->getFile();
            }

            // set header response
            $this->response->setStatusCode(500);

            // response json
            return $this->response->setJSON([
                'status' => false,
                'message' => $msg,
            ]);
        }
    }
}
