<?php

function load_model($model)
{
    $path = '../app/models/' . $model . '.php';
    if (!file_exists($path)) {
        return false;
    }
    require_once $path;
    return true;
}

function load_view($view, $data = [])
{
    if (is_array($data) && !empty($data)) {
        extract($data);
    }
    $path = '../app/views/' . $view . '.php';
    if (!file_exists($path)) {
        http_response_code(404);
        echo "View not found.";
        return;
    }
    require_once $path;
}
