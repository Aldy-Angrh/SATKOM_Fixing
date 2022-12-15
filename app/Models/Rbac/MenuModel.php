<?php

namespace App\Models\Rbac;

use CodeIgniter\Model;

class MenuModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'menu';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name',
        'controller',
        'action',
        'icon',
        'order',
        'parent_id',
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
        'controller' => 'required',
        'icon' => 'required',
    ];
    protected $validationMessages   = [
        'name' => [
            'required' => 'Nama harus diisi',
        ],
        'controller' => [
            'required' => 'Controller harus diisi',
        ],
        'action' => [
            'required' => 'Action harus diisi',
        ],
        'icon' => [
            'required' => 'Icon harus diisi',
        ],
        'order' => [
            'required' => 'Order harus diisi',
        ],
        'parent_id' => [
            'required' => 'Parent harus diisi',
        ],
    ];

    public function scenario()
    {
        return [
            'store' => [
                'name' => 'required',
                'controller' => 'required',
                'action' => 'required',
                'icon' => 'required',
                'order' => 'required',
                'parent_id' => 'required',
            ],
            'update' => [
                'name' => 'required',
                'controller' => 'required',
                'action' => 'required',
                'icon' => 'required',
                'order' => 'required',
                'parent_id' => 'required',
            ],
        ];
    }

    public function buildTree($data, $role = null)
    {
        $results = [];

        foreach ($data as $row) {
            // check if role has access to this menu
            if ($role) {
                $modelRoleMenu = new RoleMenuModel;
                $hasAccess = $modelRoleMenu->where('role_id', $role)
                    ->where('menu_id', $row['id'])
                    ->first();

                if ($hasAccess) {
                    $row['has_access'] = true;
                } else {
                    $row['has_access'] = false;
                }
            }
            $row['children'] = $this->getTreeChild($row['id'], $role);
            $results[] = $row;
        }

        return $results;
    }

    public function getTree($role = null)
    {
        $data = $this
            ->where(['parent_id' => null])
            ->orderBy('order', 'ASC')
            ->get()
            ->getResult('array');
        return $this->buildTree($data, $role);
    }

    public function getTreeChild($parent_id, $role = null)
    {
        $data = $this
            ->where(['parent_id' => $parent_id])
            ->orderBy('order', 'ASC')
            ->get()
            ->getResult('array');
        return $this->buildTree($data, $role);
    }

    public function buildOrderableHtml($data)
    {
        $html = '<ol class="dd-list">';
        foreach ($data as $row) {
            $html .= '<li class="dd-item" data-id="' . $row['id'] . '">';
            $html .= '<div class="dd-handle"> = </div><div class="dd-content">'
                // add icon
                . '<i class="fa ' . $row['icon'] . '" style="margin-right: 1rem"></i>'
                . $row['name']
                . '</div>'
                // edit button
                . (rbac_can('admin.rbac.menu.update') && rbac_can('admin.rbac.menu.show') ? '<div data-url-update="' . rbac_url('admin.rbac.menu.update', $row['id']) . '" data-url-show="' . rbac_url('admin.rbac.menu.show', $row['id']) . '" class="dd-edit">
                    <i class="fa fa-edit"></i>
                </div>' : null)
                // delete button
                . (rbac_can('admin.rbac.menu.destroy') ? '<div data-url="' . rbac_url('admin.rbac.menu.destroy', $row['id']) . '" class="dd-delete">
                    <i class="fa fa-trash"></i>
                </div>' : null);
            if (count($row['children']) > 0) {
                $html .= $this->buildOrderableHtml($row['children']);
            }
            $html .= '</li>';
        }
        $html .= '</ol>';
        return $html;
    }

    public function updateOrderAndParent($data, $parent_id = null)
    {
        foreach ($data as $key => $row) {
            $this->update($row['id'], [
                'order' => $key,
                'parent_id' => $parent_id,
            ]);

            if (isset($row['children'])) {
                $this->updateOrderAndParent($row['children'], $row['id']);
            }
        }
    }

    public static function generateChildMenu($parent_id)
    {
        $menu = new MenuModel();
        $data = $menu
            ->where(['parent_id' => $parent_id])
            ->orderBy('order', 'ASC')
            ->join('role_menu', 'role_menu.menu_id = menu.id')
            ->where('role_menu.role_id', session()->get('role_id'))
            ->select('menu.*')
            ->get()
            ->getResult('array');
        $html = '';

        foreach ($data as $row) {
            if ($menu->hasChild($row['id'])) {
                $html .= '<li class="treeview">
                    <a href="#">
                        <i class="fa ' . $row['icon'] . '"></i> <span>' . $row['name'] . '</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">';
                $html .= self::generateChildMenu($row['id']);
                $html .= '</ul>
                </li>';
            } else {
                $html .= '<li>
                    <a href="' . rbac_url($row['controller']) . '">
                        <i class="fa ' . $row['icon'] . '"></i> <span>' . $row['name'] . '</span>
                    </a>
                </li>';
            }
        }

        return $html;
    }

    public function hasChild($id)
    {
        $data = $this
            ->where(['parent_id' => $id])
            ->orderBy('order', 'ASC')
            ->get()
            ->getResult('array');
        return count($data) > 0;
    }


    public static function generateMenu()
    {
        $menu = new MenuModel();
        $data = $menu
            ->where(['parent_id' => null])
            ->orderBy('order', 'ASC')
            ->join('role_menu', 'role_menu.menu_id = menu.id')
            ->where('role_menu.role_id', session()->get('role_id'))
            ->select('menu.*')
            ->get()
            ->getResult('array');
        $html = '';
        foreach ($data as $row) {
            if ($menu->hasChild($row['id'])) {
                $html .= '<li class="treeview">
                    <a href="#">
                        <i class="fa ' . $row['icon'] . '"></i> <span>' . $row['name'] . '</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">';
                $html .= self::generateChildMenu($row['id']);
                $html .= '</ul>
                </li>';
            } else {
                $html .= '<li>
                    <a href="' . ($row['controller'] == 'admin.v2.dashboard' ? base_url('admin/v2/dashboard') : rbac_url($row['controller'])) . '">
                        <i class="fa ' . $row['icon'] . '"></i> <span>' . $row['name'] . '</span>
                    </a>
                </li>';
            }
        }

        return $html;
    }
}
