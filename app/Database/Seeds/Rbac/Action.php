<?php

namespace App\Database\Seeds\Rbac;

use CodeIgniter\Database\Seeder;

class Action extends Seeder
{
    public function run()
    {
        $data = [
            0 =>
            [
                'id' =>  '254',
                'controller_id' =>  '\\App\\Controllers\\Admin\\Dashboard',
                'action_id' =>  'index',
                'name' =>  'index (GET]',
                'alias' =>  'admin.dashboard',
            ],
            1 =>
            [
                'id' =>  '265',
                'controller_id' =>  '\\App\\Controllers\\Rbac\\Role',
                'action_id' =>  'action',
                'name' =>  'action (GET]',
                'alias' =>  'admin.rbac.role.action',
            ],
            2 =>
            [
                'id' =>  '268',
                'controller_id' =>  '\\App\\Controllers\\Rbac\\Role',
                'action_id' =>  'menu',
                'name' =>  'menu (GET]',
                'alias' =>  'admin.rbac.role.menu',
            ],
            3 =>
            [
                'id' =>  '269',
                'controller_id' =>  '\\App\\Controllers\\Rbac\\Role',
                'action_id' =>  'saveMenu',
                'name' =>  'saveMenu (POST]',
                'alias' =>  'admin.rbac.role.save-menu',
            ],
            4 =>
            [
                'id' =>  '272',
                'controller_id' =>  '\\App\\Controllers\\Rbac\\Role',
                'action_id' =>  'updateAction',
                'name' =>  'updateAction (POST]',
                'alias' =>  'admin.rbac.role.update-action',
            ],
            5 =>
            [
                'id' =>  '279',
                'controller_id' =>  '\\App\\Controllers\\Rbac\\Menu',
                'action_id' =>  'updateOrder',
                'name' =>  'updateOrder (POST]',
                'alias' =>  'admin.rbac.menu.update-order',
            ],
            6 =>
            [
                'id' =>  '318',
                'controller_id' =>  '\\App\\Controllers\\Rbac\\Menu',
                'action_id' =>  'index',
                'name' =>  'index (GET]',
                'alias' =>  'admin.rbac.menu.index',
            ],
            7 =>
            [
                'id' =>  '322',
                'controller_id' =>  '\\App\\Controllers\\Rbac\\Menu',
                'action_id' =>  'store',
                'name' =>  'store (POST]',
                'alias' =>  'admin.rbac.menu.store',
            ],
            8 =>
            [
                'id' =>  '344',
                'controller_id' =>  '\\App\\Controllers\\Rbac\\Menu',
                'action_id' =>  'orderable',
                'name' =>  'orderable (GET]',
                'alias' =>  'admin.rbac.menu.orderable',
            ],
            9 =>
            [
                'id' =>  '345',
                'controller_id' =>  '\\App\\Controllers\\Admin\\User',
                'action_id' =>  'index',
                'name' =>  'index (GET]',
                'alias' =>  'admin.user.index',
            ],
            10 =>
            [
                'id' =>  '349',
                'controller_id' =>  '\\App\\Controllers\\Admin\\User',
                'action_id' =>  'store',
                'name' =>  'store (POST]',
                'alias' =>  'admin.user.store',
            ],
            11 =>
            [
                'id' =>  '351',
                'controller_id' =>  '\\App\\Controllers\\Rbac\\Role',
                'action_id' =>  'index',
                'name' =>  'index (GET]',
                'alias' =>  'admin.rbac.role.index',
            ],
            12 =>
            [
                'id' =>  '352',
                'controller_id' =>  '\\App\\Controllers\\Rbac\\Role',
                'action_id' =>  'store',
                'name' =>  'store (POST]',
                'alias' =>  'admin.rbac.role.store',
            ],
            13 =>
            [
                'id' =>  '356',
                'controller_id' =>  '\\App\\Controllers\\Admin\\User',
                'action_id' =>  'datatable',
                'name' =>  'datatable (GET]',
                'alias' =>  'admin.user.datatable',
            ],
            14 =>
            [
                'id' =>  '357',
                'controller_id' =>  '\\App\\Controllers\\Rbac\\Role',
                'action_id' =>  'datatable',
                'name' =>  'datatable (GET]',
                'alias' =>  'admin.rbac.role.datatable',
            ],
            15 =>
            [
                'id' =>  '358',
                'controller_id' =>  '\\App\\Controllers\\Rbac\\Menu',
                'action_id' =>  'datatable',
                'name' =>  'datatable (GET]',
                'alias' =>  'admin.rbac.menu.datatable',
            ],
            16 =>
            [
                'id' =>  '359',
                'controller_id' =>  '\\App\\Controllers\\Admin\\User',
                'action_id' =>  'destroy',
                'name' =>  'destroy (DELETE]',
                'alias' =>  'admin.user.destroy',
            ],
            17 =>
            [
                'id' =>  '360',
                'controller_id' =>  '\\App\\Controllers\\Admin\\User',
                'action_id' =>  'show',
                'name' =>  'show (GET]',
                'alias' =>  'admin.user.show',
            ],
            18 =>
            [
                'id' =>  '361',
                'controller_id' =>  '\\App\\Controllers\\Admin\\User',
                'action_id' =>  'update',
                'name' =>  'update (PUT]',
                'alias' =>  'admin.user.update',
            ],
            19 =>
            [
                'id' =>  '362',
                'controller_id' =>  '\\App\\Controllers\\Rbac\\Role',
                'action_id' =>  'destroy',
                'name' =>  'destroy (DELETE]',
                'alias' =>  'admin.rbac.role.destroy',
            ],
            20 =>
            [
                'id' =>  '363',
                'controller_id' =>  '\\App\\Controllers\\Rbac\\Role',
                'action_id' =>  'show',
                'name' =>  'show (GET]',
                'alias' =>  'admin.rbac.role.show',
            ],
            21 =>
            [
                'id' =>  '364',
                'controller_id' =>  '\\App\\Controllers\\Rbac\\Role',
                'action_id' =>  'update',
                'name' =>  'update (PUT]',
                'alias' =>  'admin.rbac.role.update',
            ],
            22 =>
            [
                'id' =>  '365',
                'controller_id' =>  '\\App\\Controllers\\Rbac\\Menu',
                'action_id' =>  'destroy',
                'name' =>  'destroy (DELETE]',
                'alias' =>  'admin.rbac.menu.destroy',
            ],
            23 =>
            [
                'id' =>  '366',
                'controller_id' =>  '\\App\\Controllers\\Rbac\\Menu',
                'action_id' =>  'show',
                'name' =>  'show (GET]',
                'alias' =>  'admin.rbac.menu.show',
            ],
            24 =>
            [
                'id' =>  '367',
                'controller_id' =>  '\\App\\Controllers\\Rbac\\Menu',
                'action_id' =>  'update',
                'name' =>  'update (PUT]',
                'alias' =>  'admin.rbac.menu.update',
            ],
            25 =>
            [
                'id' =>  '368',
                'controller_id' =>  '\\App\\Controllers\\Admin\\User',
                'action_id' =>  'storeProfile',
                'name' =>  'storeProfile (POST]',
                'alias' =>  'admin.user.store-profile',
            ],
            26 =>
            [
                'id' =>  '369',
                'controller_id' =>  '\\App\\Controllers\\Admin\\User',
                'action_id' =>  'profile',
                'name' =>  'profile (GET]',
                'alias' =>  'admin.user.profile',
            ],
        ];

        foreach ($data as $key => $value) {
            $this->db->table('action')->insert(
                $value
            );
        }
    }
}
