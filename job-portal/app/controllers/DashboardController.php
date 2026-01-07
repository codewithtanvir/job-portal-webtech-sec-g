<?php

require_once '../core/Controller.php';
require_once '../core/Auth.php';

function dashboard_index()
{
    if (!auth_is_logged_in()) {
        header('Location: /job-portal/public/auth/login');
        exit;
    }
    load_view('dashboard');
}
