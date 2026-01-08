<?php

$validation_errors = [];

function validate_email($email, $fieldName = 'Email')
{
    global $validation_errors;
    $email = trim($email);

    if (empty($email)) {
        $validation_errors[] = "$fieldName is required";
        return false;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $validation_errors[] = "$fieldName must be a valid email address";
        return false;
    }

    if (strlen($email) > 255) {
        $validation_errors[] = "$fieldName is too long";
        return false;
    }

    return true;
}

function validate_password($password, $fieldName = 'Password')
{
    global $validation_errors;

    if (empty($password)) {
        $validation_errors[] = "$fieldName is required";
        return false;
    }

    if (strlen($password) < 8) {
        $validation_errors[] = "$fieldName must be at least 8 characters long";
        return false;
    }

    if (!preg_match('/[A-Z]/', $password)) {
        $validation_errors[] = "$fieldName must contain at least one uppercase letter";
        return false;
    }

    if (!preg_match('/[a-z]/', $password)) {
        $validation_errors[] = "$fieldName must contain at least one lowercase letter";
        return false;
    }

    if (!preg_match('/\d/', $password)) {
        $validation_errors[] = "$fieldName must contain at least one number";
        return false;
    }

    return true;
}

function validate_required($value, $fieldName, $minLength = 1, $maxLength = 255)
{
    global $validation_errors;
    $value = trim($value);

    if (empty($value)) {
        $validation_errors[] = "$fieldName is required";
        return false;
    }

    if (strlen($value) < $minLength) {
        $validation_errors[] = "$fieldName must be at least $minLength characters";
        return false;
    }

    if (strlen($value) > $maxLength) {
        $validation_errors[] = "$fieldName must not exceed $maxLength characters";
        return false;
    }

    return true;
}

function validate_phone($phone, $fieldName = 'Phone')
{
    global $validation_errors;
    $phone = trim($phone);

    if (empty($phone)) {
        $validation_errors[] = "$fieldName is required";
        return false;
    }

    $cleanPhone = preg_replace('/[\s\-\(\)\+]/', '', $phone);

    if (!preg_match('/^\d{10,15}$/', $cleanPhone)) {
        $validation_errors[] = "$fieldName must be a valid phone number (10-15 digits)";
        return false;
    }

    return true;
}

function validate_file($file, $fieldName, $allowedTypes = [], $maxSize = 5242880)
{
    global $validation_errors;

    if (!isset($file) || $file['error'] === UPLOAD_ERR_NO_FILE) {
        $validation_errors[] = "$fieldName is required";
        return false;
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        $validation_errors[] = "Error uploading $fieldName";
        return false;
    }

    if ($file['size'] > $maxSize) {
        $maxSizeMB = $maxSize / (1024 * 1024);
        $validation_errors[] = "$fieldName must not exceed {$maxSizeMB}MB";
        return false;
    }

    if (!empty($allowedTypes)) {
        $fileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $mimeType = mime_content_type($file['tmp_name']);

        if (!in_array($fileExt, $allowedTypes)) {
            $validation_errors[] = "$fieldName must be one of: " . implode(', ', $allowedTypes);
            return false;
        }

        if ($fileExt === 'pdf' && $mimeType !== 'application/pdf') {
            $validation_errors[] = "$fieldName must be a valid PDF file";
            return false;
        }
    }

    return true;
}

function validate_integer($value, $fieldName, $min = null, $max = null)
{
    global $validation_errors;

    if (!is_numeric($value) || $value != (int)$value) {
        $validation_errors[] = "$fieldName must be a valid number";
        return false;
    }

    $value = (int)$value;

    if ($min !== null && $value < $min) {
        $validation_errors[] = "$fieldName must be at least $min";
        return false;
    }

    if ($max !== null && $value > $max) {
        $validation_errors[] = "$fieldName must not exceed $max";
        return false;
    }

    return true;
}

function sanitize_string($value)
{
    return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
}

function sanitize_email($email)
{
    return filter_var(trim($email), FILTER_SANITIZE_EMAIL);
}

function get_validation_errors()
{
    global $validation_errors;
    return $validation_errors;
}

function has_validation_errors()
{
    global $validation_errors;
    return !empty($validation_errors);
}

function get_first_validation_error()
{
    global $validation_errors;
    return !empty($validation_errors) ? $validation_errors[0] : null;
}

function clear_validation_errors()
{
    global $validation_errors;
    $validation_errors = [];
}
