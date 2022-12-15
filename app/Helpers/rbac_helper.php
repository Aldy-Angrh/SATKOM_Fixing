<?php

if (!function_exists('rbac_url')) {
    function rbac_url($routeName = null, ...$args)
    {
        // check if has access to this permission
        $roleActionModel = new \App\Models\Rbac\RoleActionModel();

        // check route name is exist
        $action = $roleActionModel
            ->join('action', 'action.id = role_action.action_id')
            ->where('alias', $routeName)
            ->where('role_id', session()->get('role_id'))
            ->first();

        if (!$action) {
            return false;
        } else {
            try {
                return url_to($routeName, ...$args);
            } catch (Exception $e) {
                return false;
            }
        }
    }
}

if (!function_exists('rbac_can')) {
    function rbac_can($routeName = null, ...$args)
    {
        // check if has access to this permission
        $roleActionModel = new \App\Models\Rbac\RoleActionModel();

        // check route name is exist
        $action = $roleActionModel
            ->join('action', 'action.id = role_action.action_id')
            ->where('alias', $routeName)
            ->where('role_id', session()->get('role_id'))
            ->first();

        if (!$action) {
            return false;
        } else {
            return true;
        }
    }
}
