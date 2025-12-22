<?php
require_once __DIR__ . '/View.php';

class Router
{
    // store all routes as a list per method
    private array $routes = [];

    private function register($method, $path, $handler, $middleware)
    {
        // store each route as a list instead of keyed by path
        $this->routes[$method][] = [
            'path' => $path,
            'handler' => $handler,
            'middleware' => $middleware
        ];
    }

    public function get($path, $handler, $middleware = [])
    {
        $this->register('GET', $path, $handler, $middleware);
    }

    public function post($path, $handler, $middleware = [])
    {
        $this->register('POST', $path, $handler, $middleware);
    }

    public function match(array $methods, $path, $handler, $middleware = [])
    {
        foreach ($methods as $method)
        {
            $this->register($method, $path, $handler, $middleware);
        }
    }

    public function dispatch()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = strtok($_SERVER['REQUEST_URI'], '?');

        if (!isset($this->routes[$method]))
        {
            http_response_code(404);
            echo "404 Not Found";
            return;
        }

        foreach ($this->routes[$method] as $route)
        {
            $path = $route['path'];

            // Convert :param to named regex (only digits here)
            $regex = preg_replace('#:([a-zA-Z_]+)#', '(?P<$1>\d+)', $path);
            $regex = "#^$regex$#";

            if (preg_match($regex, $uri, $matches))
            {
                // Extract only named parameters
                $params = [];
                foreach ($matches as $key => $value)
                {
                    if (!is_int($key))
                    {
                        $params[$key] = $value;
                    }
                }

                // Run middleware
                foreach ($route['middleware'] as $m)
                {
                    [$class, $param] = array_pad(explode(':', $m), 2, null);
                    $file = __DIR__ . "/../Middleware/{$class}.php";
                    if (!file_exists($file))
                        throw new Exception("Middleware file not found: $file");
                    require_once $file;
                    (new $class)->handle($param);
                }

                // Call controller
                $handler = $route['handler'];
                if (is_string($handler))
                {
                    [$ctrl, $func] = explode('@', $handler);
                    $file = __DIR__ . "/../Controllers/{$ctrl}.php";
                    if (!file_exists($file))
                        throw new Exception("Controller file not found: $file");
                    require_once $file;
                    return (new $ctrl)->$func(...array_values($params));
                }

                // Callable handler
                if (is_callable($handler))
                {
                    return $handler(...array_values($params));
                }

                // Direct view
                if (is_array($handler) && isset($handler['view']))
                {
                    return View::render($handler['view'], $params);
                }
            }
        }

        http_response_code(404);
        echo "404 Not Found";
    }
}
