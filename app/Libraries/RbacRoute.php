<?php

namespace App\Libraries;

use CodeIgniter\Router\RouteCollectionInterface;

/**
 * Wrapper for CodeIgniter's RouteCollection class.
 */
class RbacRoute
{
    /**
     * Route from CI4
     */
    protected $routes;

    protected $uri = '';

    protected $middleware = [
        'as' => '',
        'filter' => '',
        'namespace' => '',
    ];


    public function __construct($routes)
    {
        $this->routes = $routes;
    }

    /**
     * Get all routes
     */
    public function getRoutesPriv()
    {
        return $this->routes;
    }

    protected function mergeOptions($options)
    {
        // merge middleware from parent with options, join as and namespace
        // $options = array_merge($this->middleware, $options);
        $options['as'] = ($this->middleware['as'] ?? '') . ($options['as'] ?? '');
        $options['namespace'] = ($this->middleware['namespace'] ?? '') . ($options['namespace'] ?? '');
        $options['filter'] = $options['filter'] ?? $this->middleware['filter'] ?? '';

        if ($options['filter'] == '') {
            unset($options['filter']);
        }

        if ($options['namespace'] == '') {
            unset($options['namespace']);
        }

        if ($options['as'] == '') {
            unset($options['as']);
        }

        return $options;
    }

    protected function mergeUri($uri)
    {
        // merge uri from parent with uri
        $uri = str_replace('//', '/', $this->uri . '/' . $uri);
        return $uri;
    }

    /**
     * group routes
     */
    public function group($uri, ...$arguments)
    {
        $currentOptions = $this->middleware;
        $currentUri = $this->uri;
        $options = [];
        $callback = null;

        foreach ($arguments as $argument) {
            if (is_callable($argument)) {
                $callback = $argument;
            } else {
                $options = $argument;
            }
        }

        $options = $this->mergeOptions($options);
        $uri = $this->mergeUri($uri);

        $this->middleware = $options;
        $this->uri = $uri;

        $callback($this);

        $this->middleware = $currentOptions;
        $this->uri = $currentUri;
    }

    /**
     * register route get
     */
    public function get($uri, $action, $options = [])
    {
        $options = $this->mergeOptions($options);
        $uri = $this->mergeUri($uri);
        $this->routes->get($uri, $action, $options);
    }

    /**
     * register route post
     */
    public function post($uri, $action, $options = [])
    {
        $options = $this->mergeOptions($options);
        $uri = $this->mergeUri($uri);
        $this->routes->post($uri, $action, $options);
    }

    /**
     * register route put
     */
    public function put($uri, $action, $options = [])
    {
        $options = $this->mergeOptions($options);
        $uri = $this->mergeUri($uri);
        $this->routes->put($uri, $action, $options);
    }

    /**
     * register route delete
     */
    public function delete($uri, $action, $options = [])
    {
        $options = $this->mergeOptions($options);
        $uri = $this->mergeUri($uri);
        $this->routes->delete($uri, $action, $options);
    }

    /**
     * register route patch
     */
    public function patch($uri, $action, $options = [])
    {
        $options = $this->mergeOptions($options);
        $uri = $this->mergeUri($uri);
        $this->routes->patch($uri, $action, $options);
    }

    /**
     * register route options
     */
    public function options($uri, $action, $options = [])
    {
        $options = $this->mergeOptions($options);
        $uri = $this->mergeUri($uri);
        $this->routes->options($uri, $action, $options);
    }

    /**
     * register route head
     */
    public function head($uri, $action, $options = [])
    {
        $options = $this->mergeOptions($options);
        $uri = $this->mergeUri($uri);
        $this->routes->head($uri, $action, $options);
    }

    /**
     * register route any
     */
    public function any($uri, $action, $options = [])
    {
        $options = $this->mergeOptions($options);
        $uri = $this->mergeUri($uri);
        $this->routes->any($uri, $action, $options);
    }

    public function resource($uri, $controller, $options = [])
    {
        helper('string');
        $options = $this->mergeOptions($options);

        // reflect controller
        $controllers = explode('\\', $controller);
        $controllerName = end($controllers);
        $snakeController = snake_case($controllerName);
        $realController = $controller;

        if (isset($options['namespace'])) {
            $realController = $options['namespace'] . "\\" . $controller;
        } else {
            // first charactor is not backslash
            if (strpos($controller, '\\') !== 0) {
                $realController = "\\App\\Controllers\\" . $controller;
            }
        }

        $reflector = new \ReflectionClass($realController);

        // if index method exists, register get
        $methods = [
            'index' => [
                'uri' => '/',
                'method' => 'get',
                'options' => [
                    'as' => "$snakeController.index",
                ],
            ],
            'datatable' => [
                'uri' => '/datatable',
                'method' => 'get',
                'options' => [
                    'as' => "$snakeController.datatable",
                ],
            ],
            'store' => [
                'uri' => '/store',
                'method' => 'post',
                'options' => [
                    'as' => "$snakeController.store",
                ],
            ],
            'update/$1' => [
                'uri' => '/update/(:num)',
                'method' => 'put',
                'options' => [
                    'as' => "$snakeController.update",
                ],
            ],
            'destroy/$1' => [
                'uri' => '/destroy/(:num)',
                'method' => 'delete',
                'options' => [
                    'as' => "$snakeController.destroy",
                ],
            ],
            'show/$1' => [
                'uri' => '/show/(:num)',
                'method' => 'get',
                'options' => [
                    'as' => "$snakeController.show",
                ],
            ],

        ];

        foreach ($methods as $method => $data) {
            // check if method exists
            $realMethod = explode('/', $method)[0];
            if ($reflector->hasMethod($realMethod)) {
                $fn = $data['method'];
                $fullUri = str_replace("//", "/",  $uri . $data['uri']);
                $fullMethod = "$controller::$method";
                $opts = $data['options'];

                $this->$fn($fullUri, $fullMethod, $opts);
            }
        }
    }


    /**
     * If function not exist here, call it from CI4 RouteCollection
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->routes, $name], $arguments);
    }
}
