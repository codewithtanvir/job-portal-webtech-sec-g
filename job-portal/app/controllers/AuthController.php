<?php

require_once '../core/Controller.php';
require_once '../core/Auth.php';
require_once '../app/models/User.php';

function auth_json($payload)
{
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($payload);
}

function auth_post($key, $default = '')
{
    return isset($_POST[$key]) ? trim((string)$_POST[$key]) : $default;
}


function auth_register()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        load_view('auth/register');
        return;
    }

    $username = auth_post('username');
    $email = auth_post('email');
    $password = auth_post('password');
    $dob = auth_post('dob');
    $role = auth_post('role');

    $allowedRoles = ['admin', 'employer', 'seeker'];
    if ($username === '' || $email === '' || $password === '' || $dob === '' || !in_array($role, $allowedRoles, true)) {
        auth_json(['status' => 'error', 'message' => 'Please fill in all fields correctly.']);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        auth_json(['status' => 'error', 'message' => 'Please enter a valid email address.']);
        exit;
    }

    $data = [
        'username' => $username,
        'email' => $email,
        'password' => $password,
        'dob' => $dob,
        'role' => $role,
        'otp' => (string)random_int(100000, 999999)
    ];

    if (addUser($data)) {
        auth_json([
            'status' => 'success',
            'message' => 'Registration successful. Check your email for OTP.',
            'otp' => $data['otp']
        ]);
    } else {
        auth_json(['status' => 'error', 'message' => 'Registration failed. Try a different email/username.']);
    }
    exit;
}

function auth_login()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        load_view('auth/login');
        return;
    }

    $email = auth_post('email');
    $password = auth_post('password');

    if ($email === '' || $password === '') {
        auth_json(['status' => 'error', 'message' => 'Email and password are required.']);
        exit;
    }

    $user = login(['email' => $email, 'password' => $password]);
    if (!$user) {
        auth_json(['status' => 'error', 'message' => 'Invalid email or password.']);
        exit;
    }

    if (empty($user['is_verified'])) {
        auth_json(['status' => 'error', 'message' => 'Please verify your email first.']);
        exit;
    }

    auth_set_login_session($user);
    setcookie('status', 'true', time() + 3000, '/');
    auth_json(['status' => 'success', 'message' => 'Login successful.', 'role' => $user['role']]);
    exit;
}

function auth_verify()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        load_view('auth/verify');
        return;
    }

    $email = auth_post('email');
    $otp = auth_post('otp');

    if ($email === '' || $otp === '') {
        auth_json(['status' => 'error', 'message' => 'Email and OTP are required.']);
        exit;
    }

    if (verifyUserOTP($email, $otp)) {
        auth_json(['status' => 'success', 'message' => 'Email verified successfully.']);
    } else {
        auth_json(['status' => 'error', 'message' => 'Invalid OTP.']);
    }
    exit;
}

function auth_forgotpassword()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        load_view('auth/forgot_password');
        return;
    }

    $email = auth_post('email');
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        auth_json(['status' => 'error', 'message' => 'Please enter a valid email address.']);
        exit;
    }

    $token = bin2hex(random_bytes(50));

    if (setResetToken($email, $token)) {
        auth_json(['status' => 'success', 'message' => 'Reset link sent to your email.', 'token' => $token]);
    } else {
        auth_json(['status' => 'error', 'message' => 'Email not found.']);
    }
    exit;
}

function auth_resetpassword()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        load_view('auth/reset_password', ['token' => $_GET['token'] ?? '']);
        return;
    }

    $token = auth_post('token');
    $password = auth_post('password');

    if ($token === '' || $password === '') {
        auth_json(['status' => 'error', 'message' => 'Token and new password are required.']);
        exit;
    }

    if (resetUserPassword($token, $password)) {
        auth_json(['status' => 'success', 'message' => 'Password reset successful.']);
    } else {
        auth_json(['status' => 'error', 'message' => 'Invalid or expired token.']);
    }
    exit;
}

function auth_logout()
{
    auth_logout_user();
    header('Location: /job-portal/public/');
    exit;
}
