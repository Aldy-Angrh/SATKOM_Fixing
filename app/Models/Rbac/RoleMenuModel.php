<?php

namespace App\Models\Rbac;

use CodeIgniter\Model;

class RoleMenuModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'role_menu';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'role_id',
        'menu_id',
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
        'menu_id' => 'required',
    ];
    protected $validationMessages   = [
        'role_id' => [
            'required' => 'Role harus diisi',
        ],
        'menu_id' => [
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
                'menu_id' => 'required',
            ],
            'update' => [
                'role_id' => 'required',
                'menu_id' => 'required',
            ],
        ];
    }

    public function updateRoleMenu($role_id, $menus)
    {
        try {
            // get all menu
            $allMenu = $this
                ->where('role_id', $role_id)
                ->get()
                ->getResult('array');

            $data = [];
            foreach ($menus as $menuId) {
                $data[] = [
                    'role_id' => $role_id,
                    'menu_id' => $menuId,
                ];
            }

            // get new menu inserted
            $newMenu = array_udiff($data, $allMenu, function ($a, $b) {
                return $a['menu_id'] - $b['menu_id'];
            });

            // get menu deleted
            $deletedMenu = array_udiff($allMenu, $data, function ($a, $b) {
                return $a['menu_id'] - $b['menu_id'];
            });

            // insert new menu
            if (!empty($newMenu)) {
                $this->insertBatch($newMenu);
            }

            // delete deleted menu
            if (!empty($deletedMenu)) {
                foreach ($deletedMenu as $menu) {
                    $this->delete($menu['id']);
                }
            }

            return true;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
