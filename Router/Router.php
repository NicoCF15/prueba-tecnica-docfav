<?php

/**
* Abstract implementation of server router
*
* The router class can define routes to simulate an api and consume the
* services the api give.
* 
*/
class Router
{
    private $routes = [];

    /**
    * Implements a get route to consume
    *
    * @param $route route method.
    * @param $callback the function to execute in the route.
    * @return void
    */
    public function get($route, $callback)
    {
        $this->addRoute('GET', $route, $callback);
    }

    /**
    * Implements a post route to consume
    *
    * @param $route route method.
    * @param $callback the function to execute in the route.
    * @return void
    */
    public function post($route, $callback)
    {
        $this->addRoute('POST', $route, $callback);
    }

    /**
    * Add routes to route array
    *
    * @param $method route method.
    * @param $route the route name.
    * @param $callback the function to execute in the route.
    * @return void
    */
    private function addRoute($method, $route, $callback)
    {
        $this->routes[] = [
            'method' => $method,
            'route' => $route,
            'callback' => $callback
        ];
    }

    /**
    * Create the routes in the server
    * @return void
    */
    public function run()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        foreach ($this->routes as $route) {
            $pattern = '#^' . preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[a-zA-Z0-9_]+)', $route['route']) . '$#';
            
            if ($method == $route['method'] && preg_match($pattern, $uri, $matches)) {
                array_shift($matches); 
                
                call_user_func_array($route['callback'], $matches);
                return;
            }
        }

        http_response_code(404);
        echo "404 - Ruta no encontrada";
    }
}
