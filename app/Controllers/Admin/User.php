<?php

namespace App\Controllers\Admin;

use App\Controllers\MyController;

class User extends MyController
{
    protected $model = '\App\Models\User';
    protected $viewFolder = 'admin/user/';

    protected $data = [
        'title' => 'Pengguna',
        'subtitle' => 'Daftar Pengguna',
        'url' => 'admin.user',
        'primary_key' => 'id',
    ];

    protected $fields = [
        'id' => [
            'label' => 'ID',
            'show' => false,
        ],
        'name' => [
            'label' => 'Nama',
            'show' => false,
        ],
        'email' => [
            'label' => 'Email',
            'show' => false,
        ],
        'username' => [
            'label' => 'Username',
            'show' => true,
        ],
        'password' => [
            'label' => 'Password',
            'show' => false,
        ],
        'role_id' => [
            'label' => 'Role',
            'show' => true,
        ],
        'login_token' => [
            'label' => 'Login Token',
            'show' => false,
        ],
        'phone_number' => [
            'label' => 'No HP',
            'show' => false,
        ],
    ];

    protected function prepareDataTable($datatable)
    {
        return $datatable
            ->add('action', function ($row) {
                $url = $this->data['url'];

                $actions = [
                    [
                        'class' => 'btn btn-sm btn-primary dtbl-redirect',
                        'icon' => 'fa fa-eye',
                        'url' =>  rbac_url($url . '.show', $row->id),
                    ],
                    [
                        'class' => 'btn btn-sm btn-warning dtbl-edit',
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
                ];
                return $this->generateActionTable($actions);
            })
            ->edit('role_id', function ($row) {
                $model = new $this->model;
                $role = $model->getRole($row->role_id);
                return $role ? $role->name : '-';
            })
            ->edit('password', function ($row) {
                return '********';
            })
            ->edit('login_token', function ($row) {
                return $row->login_token ? 'Aktif' : 'Tidak Aktif';
            });
    }

    public function prepareDataShow($data)
    {
        $model = new $this->model;
        $data->role = $model->getRole($data->role_id);

        // remove sensitive data
        unset($data->password);
        unset($data->login_token);


        return $data;
    }

    public function beforeShow($data)
    {
        $data['title'] = 'Pengguna : ' . $data['data']->name;
        return $data;
    }

    public function prepareDataUpdate($data)
    {
        if ($data['password'] == '') {
            unset($data['password']);
        } else {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        return $data;
    }

    public function beforeIndex($data)
    {
        $model = new $this->model;
        $data['roles'] = $model->getRoles();
        return $data;
    }

    public function profile()
    {
        $model = new $this->model;
        $data = $model->find(session()->get('login_token'));
        $data->role = $model->getRole($data->role_id);

        $data = array_merge($this->data, [
            'title' => 'Profil',
            'subtitle' => 'Profil Pengguna',
            'data' => $data,
        ]);

        return view($this->viewFolder . 'profile', $data);
    }

    public function storeProfile()
    {
        $model = new $this->model;
        $user = $model->find(session()->get('login_token'));
        if (!$user) {
            $this->response->setStatusCode(404);
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'User not found',
            ]);
        }

        try {
            $data = $this->request->getPost();
            $data['id'] = $user->id;

            if ($data['password'] == '') {
                unset($data['password']);
            } else {
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            }

            if ($model->save($data)) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Data berhasil disimpan',
                ]);
            } else {
                $this->response->setStatusCode(400);
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Data gagal disimpan',
                ]);
            }
        } catch (\Throwable $th) {
            $msg = "Terjadi kesalahan saat menyimpan data";
            if (ENVIRONMENT == 'development') {
                $msg = $th->getMessage();
            }

            $this->response->setStatusCode(500);
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $msg,
            ]);
        }
    }

    public function select2()
    {
        $model = new $this->model;
        $term = $this->request->getGet('q');
        if (strlen($term) < 3) {
            return $this->response->setJSON([]);
        }
        $data = $model
            ->select('id, name as text')
            ->where('role_id', 2) // role_id 2 = signer
            ->like('name', $term)
            ->orLike('username', $term)
            ->orLike('email', $term)
            ->orLike('phone_number', $term)
            // limit 100
            ->findAll(100);

        return $this->response->setJSON([
            "results" => $data
        ])->setStatusCode(200);
    }
}
