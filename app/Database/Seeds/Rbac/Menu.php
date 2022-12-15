<?php

namespace App\Database\Seeds\Rbac;

use CodeIgniter\Database\Seeder;

class Menu extends Seeder
{
    public function run()
    {
        $data = [
            0 =>
            [
                'id' =>  '15',
                'name' =>  'Dashboard',
                'controller' =>  'admin.dashboard',
                'action' =>  '',
                'icon' =>  'fa-tachometer',
                'order' =>  '0',
                'parent_id' =>  NULL,
            ],
            1 =>
            [
                'id' =>  '16',
                'name' =>  'MENU RBAC',
                'controller' =>  '#',
                'action' =>  '',
                'icon' =>  'fa-unlock-alt',
                'order' =>  '3',
                'parent_id' =>  NULL,
            ],
            2 =>
            [
                'id' =>  '17',
                'name' =>  'MENU',
                'controller' =>  'admin.rbac.menu.index',
                'action' =>  '',
                'icon' =>  'fa-circle-o',
                'order' =>  '1',
                'parent_id' =>  '16',
            ],
            3 =>
            [
                'id' =>  '18',
                'name' =>  'HAK AKSES',
                'controller' =>  'admin.rbac.role.index',
                'action' =>  '',
                'icon' =>  'fa-exclamation-circle',
                'order' =>  '0',
                'parent_id' =>  '16',
            ],
            4 =>
            [
                'id' =>  '19',
                'name' =>  'PENGGUNA',
                'controller' =>  'admin.user.index',
                'action' =>  '',
                'icon' =>  'fa-users',
                'order' =>  '2',
                'parent_id' =>  NULL,
            ],
            5 =>
            [
                'id' =>  '28',
                'name' =>  'Riwayat Dokumen',
                'controller' =>  '#',
                'action' =>  '',
                'icon' =>  'fa-envelope',
                'order' =>  '1',
                'parent_id' =>  NULL,
            ],
        ];

        foreach ($data as $key => $value) {
            $this->db->table('menu')->insert(
                $value
            );
        }
    }
}
