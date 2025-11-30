<?php
/**
 * Simple Router Class
 * Handles URL routing for the application
 */

class Router {
    private $routes = [];
    private $baseUrl;

    public function __construct($baseUrl = BASE_URL) {
        $this->baseUrl = rtrim($baseUrl, '/');
    }

    public function get($path, $callback) {
        $this->addRoute('GET', $path, $callback);
    }

    public function post($path, $callback) {
        $this->addRoute('POST', $path, $callback);
    }

    public function put($path, $callback) {
        $this->addRoute('PUT', $path, $callback);
    }

    public function delete($path, $callback) {
        $this->addRoute('DELETE', $path, $callback);
    }

    private function addRoute($method, $path, $callback) {
        $this->routes[$method . ':' . $path] = $callback;
    }

    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = str_replace(dirname($_SERVER['SCRIPT_NAME']), '', $uri);
        $uri = '/' . trim($uri, '/');

        foreach ($this->routes as $routeKey => $callback) {
            list($routeMethod, $routePath) = explode(':', $routeKey, 2);
            
            if ($routeMethod === $method && $this->matchRoute($routePath, $uri)) {
                return call_user_func($callback);
            }
        }

        header("HTTP/1.0 404 Not Found");
        return $this->show404();
    }

    private function matchRoute($route, $uri) {
        $routeRegex = preg_replace('/\{([a-z]+)\}/', '(?P<$1>[a-zA-Z0-9-]+)', $route);
        $routeRegex = '#^' . $routeRegex . '$#';
        return preg_match($routeRegex, $uri);
    }

    private function show404() {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>404 - Page Not Found</title>
            <style>
                body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
                h1 { color: #d32f2f; }
            </style>
        </head>
        <body>
            <h1>404 - Page Not Found</h1>
            <p>The page you're looking for doesn't exist.</p>
        </body>
        </html>
        <?php
    }
}
?>
