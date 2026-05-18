<?php

namespace Framework;

use App\controllers\ErrorController;
use Error;

class Router
{
    protected $routes = [];

    /**
     * Add a new route
     * @param string $method
     * @param string $uri
     * @param string $action
     * @return void
     */

    public function registerRoute($method, $uri, $action)
    {
        list($controller, $controllerMethod) = explode('@', $action);

        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
            'controllerMethod' => $controllerMethod
        ];
    }

    /**
     * Add a GET route
     * @param string $uri
     * @param $controller
     * @return void
     */

    public function get($uri, $controller)
    {
        $this->registerRoute('GET', $uri, $controller);
    }

    /**
     * Add a POST route
     * @param string $uri
     * @param $controller
     * return void
     */

    public function post($uri, $controller)
    {
        $this->registerRoute('POST', $uri, $controller);
    }

    /**
     * Add a PUT route
     * @param string $uri
     * @param $controller
     * return void
     */

    public function put($uri, $controller)
    {
        $this->registerRoute('PUT', $uri, $controller);
    }

    /**
     * Add a DELETE route
     * @param string $uri
     * @param $controller
     * return void
     */

    public function delete($uri, $controller)
    {
        $this->registerRoute('DELETE', $uri, $controller);
    }



    /**
     * Route the request
     * @param string $uri
     * @param string $method
     * @return void
     */

    public function route($uri)
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        //check for _method input
        if ($requestMethod === 'POST' && isset($_POST['_method'])) {
            //override the request method with the value of _method
            $requestMethod = strtoupper($_POST['_method']);
        }

        foreach ($this->routes as $route) {
            //Split the current URI into segment
            $uriSegments = explode('/', trim($uri, '/'));

            //Split the route
            $routeSegments = explode('/', trim($route['uri'], '/'));

            $match = true;

            if (count($uriSegments) === count($routeSegments) && strtoupper($route['method']) === strtoupper($requestMethod)) {
                $params = [];

                $match = true;

                for ($i = 0; $i < count($uriSegments); $i++) {
                    // if the uri do not match and there is no value between the {id}
                    if (
                        $routeSegments[$i] !== $uriSegments[$i] &&
                        !preg_match('/\{(.+?)\}/', $routeSegments[$i])
                    ) {
                        $match = false;
                        break;
                    }


                    //check for param and add to $param array
                    if (preg_match('/\{(.+?)\}/', $routeSegments[$i], $matches)) {
                        $params[$matches[1]] = $uriSegments[$i];
                    }
                }

                if ($match) {
                    $controller = 'App\\controllers\\' . $route['controller'];
                    $controllerMethod = $route['controllerMethod'];

                    //instantiate the controller class
                    $controllerInstance = new $controller();
                    $controllerInstance->$controllerMethod($params);
                    return;
                }
            }
            //ErrorController::notFound();
        }
        ErrorController::notFound();
    }
}
