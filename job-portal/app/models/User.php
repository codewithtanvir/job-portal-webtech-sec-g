<?php
require_once(__DIR__ . '/../../core/db.php');

function login($user)
{
    $con = getConnection();
    $sql = "SELECT * FROM users WHERE email = ? LIMIT 1";
    $stmt = mysqli_prepare($con, $sql);
    if (!$stmt) {
        return false;
    }
    $email = (string)($user['email'] ?? '');
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = $result ? mysqli_fetch_assoc($result) : null;
    mysqli_stmt_close($stmt);

    if (!$row) {
        return false;
    }

    $password = (string)($user['password'] ?? '');
    if (password_verify($password, $row['password']) || $password === $row['password']) {
        return $row;
    }
    return false;
}

function getUserById($id)
{
    $con = getConnection();
    $sql = "SELECT * FROM users WHERE id = ? LIMIT 1";
    $stmt = mysqli_prepare($con, $sql);
    if (!$stmt) {
        return null;
    }
    $id = (int)$id;
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = $result ? mysqli_fetch_assoc($result) : null;
    mysqli_stmt_close($stmt);
    return $row;
}

function getUserByEmail($email)
{
    $con = getConnection();
    $sql = "SELECT * FROM users WHERE email = ? LIMIT 1";
    $stmt = mysqli_prepare($con, $sql);
    if (!$stmt) {
        return null;
    }
    $email = (string)$email;
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = $result ? mysqli_fetch_assoc($result) : null;
    mysqli_stmt_close($stmt);
    return $row;
}

function addUser($user)
{
    $con = getConnection();
    $hashed = password_hash((string)$user['password'], PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (username, email, password, dob, role, otp) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $sql);
    if (!$stmt) {
        return false;
    }

    $username = (string)($user['username'] ?? '');
    $email = (string)($user['email'] ?? '');
    $dob = (string)($user['dob'] ?? '');
    $role = (string)($user['role'] ?? '');
    $otp = (string)($user['otp'] ?? '');

    mysqli_stmt_bind_param($stmt, 'ssssss', $username, $email, $hashed, $dob, $role, $otp);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function verifyUserOTP($email, $otp)
{
    $con = getConnection();
    $sql = "UPDATE users SET is_verified = 1, otp = NULL WHERE email = ? AND otp = ?";
    $stmt = mysqli_prepare($con, $sql);
    if (!$stmt) {
        return false;
    }
    $email = (string)$email;
    $otp = (string)$otp;
    mysqli_stmt_bind_param($stmt, 'ss', $email, $otp);
    mysqli_stmt_execute($stmt);
    $affected = mysqli_stmt_affected_rows($stmt);
    mysqli_stmt_close($stmt);
    return $affected > 0;
}

function setResetToken($email, $token)
{
    $con = getConnection();
    $sql = "UPDATE users SET reset_token = ? WHERE email = ?";
    $stmt = mysqli_prepare($con, $sql);
    if (!$stmt) {
        return false;
    }
    $email = (string)$email;
    $token = (string)$token;
    mysqli_stmt_bind_param($stmt, 'ss', $token, $email);
    mysqli_stmt_execute($stmt);
    $affected = mysqli_stmt_affected_rows($stmt);
    mysqli_stmt_close($stmt);
    return $affected > 0;
}

function resetUserPassword($token, $newPassword)
{
    $con = getConnection();
    $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
    $sql = "UPDATE users SET password = ?, reset_token = NULL WHERE reset_token = ?";
    $stmt = mysqli_prepare($con, $sql);
    if (!$stmt) {
        return false;
    }
    $token = (string)$token;
    mysqli_stmt_bind_param($stmt, 'ss', $hashed, $token);
    mysqli_stmt_execute($stmt);
    $affected = mysqli_stmt_affected_rows($stmt);
    mysqli_stmt_close($stmt);
    return $affected > 0;
}

function deleteUser($id)
{
    $con = getConnection();
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = mysqli_prepare($con, $sql);
    if (!$stmt) {
        return false;
    }
    $id = (int)$id;
    mysqli_stmt_bind_param($stmt, 'i', $id);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}

function updateUser($user)
{
    $con = getConnection();
    $sql = "UPDATE users SET email = ?, role = ? WHERE id = ?";
    $stmt = mysqli_prepare($con, $sql);
    if (!$stmt) {
        return false;
    }
    $email = (string)($user['email'] ?? '');
    $role = (string)($user['role'] ?? '');
    $id = (int)($user['id'] ?? 0);
    mysqli_stmt_bind_param($stmt, 'ssi', $email, $role, $id);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    return $ok;
}
