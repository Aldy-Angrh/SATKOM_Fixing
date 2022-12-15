<?php

namespace App\Models;

use App\Models\Rbac\RoleModel;
use CodeIgniter\Model;

class User extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'email', 'username', 'password', 'role_id', 'login_token','phone_number'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'name' => 'required',
        'email' => 'required|valid_email',
        'username' => 'required|is_unique[users.username,id,{id}]',
        'password' => 'required',
        'role_id' => 'required',
        'phone_number' => 'required|numeric|is_unique[users.phone_number,id,{id}]|min_length[10]|max_length[13]|regex_match[/^[0-9]+$/]',
    ];
    protected $validationMessages   = [
        'name' => [
            'required' => 'Nama harus diisi',
        ],
        'email' => [
            'required' => 'Email harus diisi',
            'valid_email' => 'Email tidak valid',
        ],
        'username' => [
            'required' => 'Username harus diisi',
            'is_unique' => 'Username sudah digunakan',
        ],
        'password' => [
            'required' => 'Password harus diisi',
        ],
        'role_id' => [
            'required' => 'Role harus diisi',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];


    public function scenario()
    {
        return [
            'store' => [
                'name' => 'required',
                'email' => 'required|valid_email',
                'username' => 'required|is_unique[users.username]',
                'password' => 'required',
                'role_id' => 'required',
                'phone_number' => 'required',
            ],
            'update' => [
                'name' => 'required',
                'email' => 'required|valid_email',
                'username' => 'required|is_unique[users.username,id,{id}]',
                'password' => 'required',
                'role_id' => 'required',
                'phone_number' => 'required',
            ],
        ];
    }

    public function getLoginUser()
    {
        $user =  $this->where('login_token', session()->login_token)->first();
        return $user;
    }

    // relation with role
    public function getRole($id)
    {
        $model = new RoleModel();
        $role = $model->where('id', $id)->get()->getRow();
        return $role;
    }

    public function getRoles()
    {
        $model = new RoleModel();
        $roles = $model->findAll();
        return $roles;
    }
}
