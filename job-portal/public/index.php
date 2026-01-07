<?php

require_once '../core/Auth.php';
auth_start_session();

$url = $_GET['url'] ?? 'home/index';
$url = trim($url, '/');

if (empty($url)) {
    $url = 'home/index';
}

$urlParts = explode('/', $url);

$controllerSlug = strtolower($urlParts[0] ?? 'home');
$methodSlug = strtolower($urlParts[1] ?? 'index');

$controllerSlug = preg_replace('/[^a-z0-9_]/', '', $controllerSlug);
$methodSlug = preg_replace('/[^a-z0-9_]/', '', $methodSlug);

$controllerName = ucfirst($controllerSlug) . 'Controller';
$controllerFile = '../app/controllers/' . $controllerName . '.php';

$functionName = $controllerSlug . '_' . $methodSlug;

if (file_exists($controllerFile)) {
    require_once $controllerFile;

    if (function_exists($functionName)) {
        call_user_func($functionName);
    } else {
        http_response_code(404);
        echo "404 - Page not found";
    }
} else {
    http_response_code(404);
    echo "404 - Page not found";
}
