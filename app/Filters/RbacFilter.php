<?php

namespace App\Filters;

use App\Models\User;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RbacFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Do something here
        $router       = \Config\Services::router();
        $route = $router->getMatchedRoute()[1];

        $route = explode('::', $route);
        $controller = $route[0];
        $action = explode('/', $route[1])[0];

        $session = session();

        // if role not in RBAC_EXCEPTS_ROLE
        if (in_array($session->role_id, RBAC_EXCEPTS_ROLE)) {
            return;
        }

        // if controller in RBAC_EXCEPTS_CONTROLLER
        if (in_array($controller, RBAC_EXCEPTS_CONTROLLER)) {
            return;
        }

        // if action in RBAC_EXCEPTS_ACTION
        if (in_array("$controller::$action", RBAC_EXCEPTS_ACTION)) {
            return;
        }

        $roleActionModel = new \App\Models\Rbac\RoleActionModel();

        $rolePermissions = $roleActionModel
            ->where('role_action.role_id', $session->role_id)
            ->join('action', 'action.id = role_action.action_id')
            ->where('action.controller_id', $controller)
            ->where('action.action_id', $action)
            ->first();

        
        if (!isset($rolePermissions)) {
            // throw forbidden
            throw new \App\Exceptions\ForbiddenException();
        }

        // if found permission, continue

    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
