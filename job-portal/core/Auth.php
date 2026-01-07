<?php

function auth_start_session()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
}

function auth_set_login_session($user)
{
    auth_start_session();
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role'] = $user['role'];
    $_SESSION['email'] = $user['email'] ?? null;
    $_SESSION['username'] = $user['username'] ?? null;
}

function auth_logout_user()
{
    auth_start_session();
    session_unset();
    session_destroy();
}

function auth_is_logged_in()
{
    auth_start_session();
    return isset($_SESSION['user_id']);
}

function auth_get_role()
{
    auth_start_session();
    return $_SESSION['role'] ?? null;
}

function auth_get_user_id()
{
    auth_start_session();
    return $_SESSION['user_id'] ?? null;
}

function auth_check_role($roles)
{
    if (!auth_is_logged_in()) {
        return false;
    }
    $userRole = auth_get_role();
    return is_array($roles) ? in_array($userRole, $roles) : $userRole === $roles;
}
