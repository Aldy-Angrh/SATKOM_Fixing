<?php

namespace App\Models\Rbac;

use CodeIgniter\Model;

class RoleModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'role';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name',
    ];

    // Dates
    // protected $useTimestamps = false;
    // protected $dateFormat    = 'datetime';
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'name' => 'required',
    ];
    protected $validationMessages   = [
        'name' => [
            'required' => 'Nama harus diisi',
        ]
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
                'name' => 'required',
            ],
            'update' => [
                'name' => 'required',
            ],
        ];
    }
}
