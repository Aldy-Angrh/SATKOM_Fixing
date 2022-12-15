<?php

namespace App\Database\Seeds\Rbac;

use CodeIgniter\Database\Seeder;

class RoleMenu extends Seeder
{
    public function run()
    {
        $data = [
            0 =>
            [
                'id' =>  '52',
                'role_id' =>  '1',
                'menu_id' =>  '15',
            ],
            1 =>
            [
                'id' =>  '53',
                'role_id' =>  '1',
                'menu_id' =>  '16',
            ],
            2 =>
            [
                'id' =>  '54',
                'role_id' =>  '1',
                'menu_id' =>  '18',
            ],
            3 =>
            [
                'id' =>  '55',
                'role_id' =>  '1',
                'menu_id' =>  '17',
            ],
            4 =>
            [
                'id' =>  '56',
                'role_id' =>  '1',
                'menu_id' =>  '19',
            ],
            5 =>
            [
                'id' =>  '62',
                'role_id' =>  '1',
                'menu_id' =>  '28',
            ],
        ];
        foreach ($data as $key => $value) {
            $this->db->table('role_menu')->insert(
                $value
            );
        }
    }
}
