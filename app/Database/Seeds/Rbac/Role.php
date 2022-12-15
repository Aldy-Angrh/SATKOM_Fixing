<?php

namespace App\Database\Seeds\Rbac;

use CodeIgniter\Database\Seeder;

class Role extends Seeder
{
    public function run()
    {
        $data = [
            0 =>
            [
                'id'   => '1',
                'name' => 'Super Administrator',
            ],
            1 =>
            [
                'id'   => '2',
                'name' => 'Administrator',
            ],
            2 =>
            [
                'id'   => '3',
                'name' => 'Regular User',
            ],
        ];
        foreach ($data as $key => $value) {
            $this->db->table('role')->insert(
                $value
            );
        }
    }
}
