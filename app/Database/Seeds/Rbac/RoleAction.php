<?php

namespace App\Database\Seeds\Rbac;

use CodeIgniter\Database\Seeder;

class RoleAction extends Seeder
{
    public function run()
    {
        $data = [
            0 =>
            [
                'id' =>  '99',
                'role_id' =>  '1',
                'action_id' =>  '265',
            ],
            1 =>
            [
                'id' =>  '106',
                'role_id' =>  '1',
                'action_id' =>  '272',
            ],
            2 =>
            [
                'id' =>  '113',
                'role_id' =>  '1',
                'action_id' =>  '279',
            ],
            3 =>
            [
                'id' =>  '116',
                'role_id' =>  '1',
                'action_id' =>  '268',
            ],
            4 =>
            [
                'id' =>  '118',
                'role_id' =>  '1',
                'action_id' =>  '269',
            ],
            5 =>
            [
                'id' =>  '141',
                'role_id' =>  '1',
                'action_id' =>  '254',
            ],
            6 =>
            [
                'id' =>  '148',
                'role_id' =>  '1',
                'action_id' =>  '318',
            ],
            7 =>
            [
                'id' =>  '152',
                'role_id' =>  '1',
                'action_id' =>  '322',
            ],
            8 =>
            [
                'id' =>  '166',
                'role_id' =>  '1',
                'action_id' =>  '351',
            ],
            9 =>
            [
                'id' =>  '167',
                'role_id' =>  '1',
                'action_id' =>  '352',
            ],
            10 =>
            [
                'id' =>  '171',
                'role_id' =>  '1',
                'action_id' =>  '344',
            ],
            11 =>
            [
                'id' =>  '172',
                'role_id' =>  '1',
                'action_id' =>  '345',
            ],
            12 =>
            [
                'id' =>  '175',
                'role_id' =>  '1',
                'action_id' =>  '349',
            ],
            13 =>
            [
                'id' =>  '177',
                'role_id' =>  '1',
                'action_id' =>  '357',
            ],
            14 =>
            [
                'id' =>  '178',
                'role_id' =>  '1',
                'action_id' =>  '358',
            ],
            15 =>
            [
                'id' =>  '179',
                'role_id' =>  '1',
                'action_id' =>  '356',
            ],
            16 =>
            [
                'id' =>  '180',
                'role_id' =>  '1',
                'action_id' =>  '362',
            ],
            17 =>
            [
                'id' =>  '181',
                'role_id' =>  '1',
                'action_id' =>  '363',
            ],
            18 =>
            [
                'id' =>  '182',
                'role_id' =>  '1',
                'action_id' =>  '364',
            ],
            19 =>
            [
                'id' =>  '183',
                'role_id' =>  '1',
                'action_id' =>  '365',
            ],
            20 =>
            [
                'id' =>  '184',
                'role_id' =>  '1',
                'action_id' =>  '366',
            ],
            21 =>
            [
                'id' =>  '185',
                'role_id' =>  '1',
                'action_id' =>  '367',
            ],
            22 =>
            [
                'id' =>  '186',
                'role_id' =>  '1',
                'action_id' =>  '359',
            ],
            23 =>
            [
                'id' =>  '187',
                'role_id' =>  '1',
                'action_id' =>  '360',
            ],
            24 =>
            [
                'id' =>  '188',
                'role_id' =>  '1',
                'action_id' =>  '361',
            ],
            25 =>
            [
                'id' =>  '189',
                'role_id' =>  '1',
                'action_id' =>  '368',
            ],
            26 =>
            [
                'id' =>  '190',
                'role_id' =>  '1',
                'action_id' =>  '369',
            ],
        ];
        
        foreach ($data as $key => $value) {
            $this->db->table('role_action')->insert(
                $value
            );
        }
    }
}
