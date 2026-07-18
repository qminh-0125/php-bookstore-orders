<?php
// app/Core/Router.php

class Router
{
    private array $routes = [];

    public function get(string $path, array $handler): void
    {
        $this->routes['GET'][$path] = $handler;
    }

    public function post(string $path, array $handler): void
    {
        $this->routes['POST'][$path] = $handler;
    }

    public function dispatch(string $method, string $uri): void
    {
        // Cat lay phan duong dan bo qua tham so GET (?id=1...)
        $path = parse_url($uri, PHP_URL_PATH) ?: '/';

        // Dung route va dung phuong thuc HTTP
        if (isset($this->routes[$method][$path])) {
            [$controller, $action] = $this->routes[$method][$path];
            (new $controller())->$action();
            return;
        }

        // Co route nhung sai phuong thuc -> Loi 405
        foreach ($this->routes as $routeMethod => $paths) {
            if ($routeMethod !== $method && isset($paths[$path])) {
                http_response_code(405);
                view('errors/405');
                return;
            }
        }

        // Khong tim thay route nao -> Loi 404
        http_response_code(404);
        view('errors/404');
    }
}
