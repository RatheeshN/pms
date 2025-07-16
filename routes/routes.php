<?php
$routes = [
    '' => ['controller' => 'AuthController', 'action' => 'login'],
    'auth/login' => ['controller' => 'AuthController', 'action' => 'login'], // Match the /auth/login URL
    'logout' => ['controller' => 'AuthController', 'action' => 'logout'],
    'dashboard' => ['controller' => 'DashboardController', 'action' => 'index'],
    'projects' => ['controller' => 'ProjectController', 'action' => 'index'],
    'projects/create' => ['controller' => 'ProjectController', 'action' => 'create'],
    'projects/edit/([0-9]+)' => ['controller' => 'ProjectController', 'action' => 'edit'],
    'projects/delete/([0-9]+)' => ['controller' => 'ProjectController', 'action' => 'delete'],
    'tasks' => ['controller' => 'TaskController', 'action' => 'index'],
    'tasks/create' => ['controller' => 'TaskController', 'action' => 'create'],
    'tasks/edit/([0-9]+)' => ['controller' => 'TaskController', 'action' => 'edit'],
    'tasks/delete/([0-9]+)' => ['controller' => 'TaskController', 'action' => 'delete'],
];

function route($uri, $routes) {
    $uri = trim($uri, '/');
    
    foreach ($routes as $route => $handler) {
        $pattern = preg_replace('#\([0-9]+\)#', '([0-9]+)', $route);
        $pattern = '#^' . $pattern . '$#';
        
        if (preg_match($pattern, $uri, $matches)) {
            array_shift($matches); // Remove full match
            return [
                'controller' => $handler['controller'],
                'action' => $handler['action'],
                'params' => $matches
            ];
        }
    }
    
    return [
        'controller' => 'ErrorController',
        'action' => 'notFound',
        'params' => []
    ];
}
?>