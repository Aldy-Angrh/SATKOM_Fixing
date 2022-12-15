<?php

namespace App\Database\Seeds\Rbac;

use CodeIgniter\Database\Seeder;

class Users extends Seeder
{
    public function run()
    {
        $data = [
            0 =>
            [
                'id' =>  '4',
                'name' =>  'user',
                'email' =>  'user@gmail.com',
                'phone_number' =>  '',
                'username' =>  'user',
                'password' =>  '$2y$10$dLwIwa3Xv7B.Onsq8nDbweurcZrhgq0Dg8qkqFyftlgEslw.QNpHq', // dev
                'role_id' =>  '3',
                'photo_url' =>  '',
                'login_token' =>  NULL,
                'is_active' =>  '1',
            ],
            1 =>
            [
                'id' =>  '1',
                'name' =>  'Developer',
                'email' =>  'dev@mail.com',
                'phone_number' =>  '0882009714993',
                'username' =>  'dev',
                'password' =>  '$2y$10$dLwIwa3Xv7B.Onsq8nDbweurcZrhgq0Dg8qkqFyftlgEslw.QNpHq', // dev
                'role_id' =>  '1',
                'photo_url' =>  '',
                'login_token' =>  '1_2022-10-31 21:00:28_DLas4r5QWhtUcfYpqMv2',
                'is_active' =>  '1',
            ],
        ];
        foreach ($data as $key => $value) {
            $this->db->table('users')->insert(
                $value
            );
        }
    }
}
