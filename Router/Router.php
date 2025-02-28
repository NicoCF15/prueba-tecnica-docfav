<?php

class Router
{
    private $routes = [];

    public function get($route, $callback)
    {
        $this->addRoute('GET', $route, $callback);
    }

    public function post($route, $callback)
    {
        $this->addRoute('POST', $route, $callback);
    }

    private function addRoute($method, $route, $callback)
    {
        $this->routes[] = [
            'method' => $method,
            'route' => $route,
            'callback' => $callback
        ];
    }

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
