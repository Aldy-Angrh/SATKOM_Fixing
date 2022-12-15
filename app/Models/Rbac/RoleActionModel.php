<?php

namespace App\Models\Rbac;

use CodeIgniter\Model;

class RoleActionModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'role_action';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'role_id',
        'action_id',
    ];

    // Dates
    // protected $useTimestamps = false;
    // protected $dateFormat    = 'datetime';
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'role_id' => 'required',
        'action_id' => 'required',
    ];
    protected $validationMessages   = [
        'role_id' => [
            'required' => 'Role harus diisi',
        ],
        'action_id' => [
            'required' => 'Menu harus diisi',
        ],
    ];

    // protected $skipValidation       = false;
    // protected $cleanValidationRules = true;

    // Callbacks
    // protected $allowCallbacks = true;
    // protected $beforeInsert   = [];
    // protected $afterInsert    = [];
    // protected $beforeUpdate   = [];
    // protected $afterUpdate    = [];
    // protected $beforeFind     = [];
    // protected $afterFind      = [];
    // protected $beforeDelete   = [];
    // protected $afterDelete    = [];

    public function scenario()
    {
        return [
            'store' => [
                'role_id' => 'required',
                'action_id' => 'required',
            ],
            'update' => [
                'role_id' => 'required',
                'action_id' => 'required',
            ],
        ];
    }
}
