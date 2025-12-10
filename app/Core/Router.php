<?php

require_once __DIR__ . '/View.php';

class Router
{
    // store all the routes here; routes[method][path] = [handler, middleware/s]
    private array $routes = []; 

    private function register($method, $path, $handler, $middleware) 
    {
        // adds a route in the routes array
        $this->routes[$method][$path] = compact('handler','middleware');
    }

    public function get($path, $handler, $middleware = []) 
    {
        // register a GET route
        $this->register('GET', $path, $handler, $middleware);
    }

    public function post($path, $handler, $middleware = []) 
    {
        // register a POST route
        $this->register('POST', $path, $handler, $middleware);
    }

    public function match(array $methods, $path, $handler, $middleware = []) 
    {
        // register the same route for multiple http methods
        foreach ($methods as $method) 
        {
            $this->register($method, $path, $handler, $middleware);
        }
    }

    public function dispatch() 
    {
        // dispatching
        
        // get the method and the query params
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = strtok($_SERVER['REQUEST_URI'], '?');

        if (!isset($this->routes[$method][$uri])) 
        {
            // no matching route exists
            http_response_code(404);
            echo "404 Not Found";
            return;
        }

        $route = $this->routes[$method][$uri];

        // middleware chain
        foreach ($route['middleware'] as $m) 
        {
            // middleware can have params
            [$class, $param] = array_pad(explode(':', $m), 2, null);
            
            // load the middleware
            $file = __DIR__ . "/../Middleware/{$class}.php";
            if (!file_exists($file)) 
                throw new Exception("Middleware file not found: $file");
            
            // enforce the middleware
            require_once $file;
            (new $class)->handle($param);
        }

        $handler = $route['handler'];
        //  Controller@method
        if (is_string($handler)) 
        {
            [$ctrl, $func] = explode('@', $handler);

            // load the controller
            $file = __DIR__ . "/../Controllers/{$ctrl}.php";
            if (!file_exists($file))
                throw new Exception("Controller file not found: $file");

            require_once $file;

            // call coresponding controller method
            $class = "{$ctrl}";
            return (new $class)->$func();
        }

        // direct view
        if (is_array($handler) && isset($handler['view'])) 
        {
            $view = $handler['view'];
            return View::render($view);
        }
    }
}
