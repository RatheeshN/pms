<?php
session_start();
require_once __DIR__ . '/../routes/routes.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$basePath = '/pms/public';
$uri = str_replace($basePath, '', $uri);
$uri = trim($uri, '/');

$route = route($uri, $routes);
$controller = $route['controller'];
$action = $route['action'];
$params = $route['params'];

$controller_file = __DIR__ . '/../controllers/' . $controller . '.php';

if (file_exists($controller_file)) {
    require_once $controller_file;
    $controller_instance = new $controller();
    if (method_exists($controller_instance, $action)) {
        if (!empty($params)) {
            call_user_func_array([$controller_instance, $action], $params);
        } else {
            $controller_instance->$action();
        }
    } else {
        http_response_code(404);
        echo 'Action not found';
    }
} else {
    http_response_code(404);
    echo 'Controller not found';
}
?>