<?php

namespace App\Models\Rbac;

use CodeIgniter\Model;

class ActionModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'action';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'controller_id',
        'action_id',
        'name',
        'alias',
    ];

    // Validation
    protected $validationRules      = [
        'controller_id' => 'required',
        'action_id' => 'required',
        'name' => 'required',
    ];
    protected $validationMessages   = [
        'controller_id' => [
            'required' => 'Controller harus diisi',
        ],
        'action_id' => [
            'required' => 'Action harus diisi',
        ],
        'name' => [
            'required' => 'Nama harus diisi',
        ],
    ];

    public function scenario()
    {
        return [
            'store' => [
                'controller_id' => 'required',
                'action_id' => 'required',
                'name' => 'required',
            ],
            'update' => [
                'controller_id' => 'required',
                'action_id' => 'required',
                'name' => 'required',
            ],
        ];
    }

    private function readableControllerName($controller)
    {
        $controller = str_replace('App\Controllers\\', '', $controller);
        $controller = str_replace('Controller', '', $controller);
        $controller = str_replace('\\', ' ', $controller);
        $controller = ucwords($controller);
        return $controller;
    }

    private function isActionAllowed($role, $action_id)
    {
        $role = $this
            ->where('action.id', $action_id)
            ->join('role_action', 'role_action.action_id = action.id')
            ->where('role_id', $role)
            ->select('action.id')
            ->first();

        return $role ? true : false;
    }

    /**
     * Readable CI4 action name
     */
    private function readableActionName($action)
    {
        return explode('/', $action)[0];
    }

    public function getActions($role)
    {
        $results = [];
        $dbResults = $this
            ->get()
            ->getResult('array');

        foreach ($dbResults as $key => $dbResult) {
            if (!isset($results[$dbResult['controller_id']])) {
                $results[$dbResult['controller_id']]['controller'] = $this->readableControllerName($dbResult['controller_id']);
            }

            $results[$dbResult['controller_id']]['actions'][] = [
                'id' => $dbResult['id'],
                'fn' => $this->readableActionName($dbResult['action_id']),
                'name' => $dbResult['name'],
                'has_access' => $this->isActionAllowed($role, $dbResult['id']),
            ];
        }

        return $results;
    }

    public function saveAllActions($controllers)
    {
        // remove all action in database
        $actionModel = new \App\Models\Rbac\ActionModel();

        // remove controller, if define in RBAC_EXCEPTS_CONTROLLER
        foreach ($controllers as $key => $controller) {
            if (in_array($controller, RBAC_EXCEPTS_CONTROLLER)) {
                unset($controllers[$key]);
            }
        }

        // save all action
        foreach ($controllers as $controller) {
            if (!isset($controller['actions'])) {
                continue;
            }
            foreach ($controller['actions'] as $action) {
                $actionName = explode('/', $action['fn'])[0];

                // remove action, if define in RBAC_EXCEPTS_ACTION
                if (in_array($controller['controller'] . '::' . $actionName, RBAC_EXCEPTS_ACTION)) {
                    continue;
                }

                $httpMethodUppercase = strtoupper($action['http_method']);

                $name = "{$actionName} ($httpMethodUppercase)";
                $data[] = [
                    'controller_id' => $controller['controller'],
                    'action_id' => $actionName,
                    'name' => $name,
                    'alias' => $action['alias'],
                ];
            }
        }

        // select all action
        $actions = $actionModel->get()->getResult('array');

        // get new action
        $newActions = array_udiff($data, $actions, function ($a, $b) {
            return $a['controller_id'] . $a['action_id'] <=> $b['controller_id'] . $b['action_id'];
        });

        // get deleted action
        $deletedActions = array_udiff($actions, $data, function ($a, $b) {
            return $a['controller_id'] . $a['action_id'] <=> $b['controller_id'] . $b['action_id'];
        });

        // insert new action
        if (count($newActions) > 0) {
            $actionModel->insertBatch($newActions);
        }

        // delete deleted action
        if (count($deletedActions) > 0) {
            foreach ($deletedActions as $action) {
                $actionModel->delete($action['id']);
            }
        }
    }

    public function getRegisteredControllers($routes)
    {
        // only allow controllers in the \App\Controllers namespace
        $controllers = $routes->getRegisteredControllers();
        $controllers = array_filter($controllers, function ($controller) {
            return strpos($controller, '\App\Controllers') === 0;
        });

        // except controllers in RBAC_EXCEPTS_CONTROLLER
        foreach ($controllers as $key => $controller) {
            if (in_array($controller, RBAC_EXCEPTS_CONTROLLER)) {
                unset($controllers[$key]);
            }
        }

        return $controllers;
    }



    public function groupRoutes($routes)
    {
        $supportHttpMethod = [
            "get",
            "head",
            "post",
            "put",
            "delete",
            "options",
        ];

        $routeExists = $routes->getRoutesOptions(null, '*');
        $excepts = array_keys($routeExists);

        $groupedRoutes = [];
        foreach ($supportHttpMethod as $httpMethod) {
            $availableRoutes = $routes->getRoutes($httpMethod);

            $routeExists = $routes->getRoutesOptions(null, $httpMethod);
            if ($routeExists) {
                foreach ($routeExists as $key => $options) {
                    if (in_array($key, $excepts)) {
                        continue;
                    }

                    $route = $availableRoutes[$key];
                    $route = explode('::', $route);
                    $controller = $route[0];
                    $action = $route[1];

                    $groupedRoutes[] = [
                        'key' => $key,
                        'http_method' => $httpMethod,
                        'controller' => $controller,
                        'fn' => $action,
                        'alias' => $options['as'] ?? $key,
                    ];
                }
            }
        }

        // order by key
        usort($groupedRoutes, function ($a, $b) {
            return $a['key'] <=> $b['key'];
        });

        return $groupedRoutes;
    }

    public function updateActions($role_id, $actions)
    {
        try {
            $roleActionModel = new \App\Models\Rbac\RoleActionModel();
            $alreadyExists = $roleActionModel
                ->where('role_id', $role_id)
                ->get()
                ->getResult('array');

            $data = [];
            foreach ($actions as $action) {
                $data[] = [
                    'role_id' => $role_id,
                    'action_id' => $action,
                ];
            }

            // get new action
            $newActions = array_udiff($data, $alreadyExists, function ($a, $b) {
                return $a['action_id'] <=> $b['action_id'];
            });

            // get deleted action
            $deletedActions = array_udiff($alreadyExists, $data, function ($a, $b) {
                return $a['action_id'] <=> $b['action_id'];
            });

            // insert new action
            if (count($newActions) > 0) {
                $roleActionModel->insertBatch($newActions);
            }

            // delete deleted action
            if (count($deletedActions) > 0) {
                foreach ($deletedActions as $action) {
                    $roleActionModel->delete($action['id']);
                }
            }

            return true;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
