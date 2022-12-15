<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Rbac extends Seeder
{
    public function run()
    {
        $this->call('App\Database\Seeds\Rbac\Action');
        $this->call('App\Database\Seeds\Rbac\Menu');
        $this->call('App\Database\Seeds\Rbac\Role');
        $this->call('App\Database\Seeds\Rbac\RoleAction');
        $this->call('App\Database\Seeds\Rbac\RoleMenu');
        $this->call('App\Database\Seeds\Rbac\Users');
    }
}
