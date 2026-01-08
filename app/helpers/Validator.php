<?php

class Validator
{
    private $errors = [];

    /**
     * Validate email format
     */
    public function validateEmail($email, $fieldName = 'Email')
    {
        $email = trim($email);

        if (empty($email)) {
            $this->errors[] = "$fieldName is required";
            return false;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "$fieldName must be a valid email address";
            return false;
        }

        if (strlen($email) > 255) {
            $this->errors[] = "$fieldName is too long";
            return false;
        }

        return true;
    }

    /**
     * Validate password strength
     */
    public function validatePassword($password, $fieldName = 'Password')
    {
        if (empty($password)) {
            $this->errors[] = "$fieldName is required";
            return false;
        }

        if (strlen($password) < 8) {
            $this->errors[] = "$fieldName must be at least 8 characters long";
            return false;
        }

        if (!preg_match('/[A-Z]/', $password)) {
            $this->errors[] = "$fieldName must contain at least one uppercase letter";
            return false;
        }

        if (!preg_match('/[a-z]/', $password)) {
            $this->errors[] = "$fieldName must contain at least one lowercase letter";
            return false;
        }

        if (!preg_match('/\d/', $password)) {
            $this->errors[] = "$fieldName must contain at least one number";
            return false;
        }

        return true;
    }

    /**
     * Validate required text field
     */
    public function validateRequired($value, $fieldName, $minLength = 1, $maxLength = 255)
    {
        $value = trim($value);

        if (empty($value)) {
            $this->errors[] = "$fieldName is required";
            return false;
        }

        if (strlen($value) < $minLength) {
            $this->errors[] = "$fieldName must be at least $minLength characters";
            return false;
        }

        if (strlen($value) > $maxLength) {
            $this->errors[] = "$fieldName must not exceed $maxLength characters";
            return false;
        }

        return true;
    }

    /**
     * Validate phone number
     */
    public function validatePhone($phone, $fieldName = 'Phone')
    {
        $phone = trim($phone);

        if (empty($phone)) {
            $this->errors[] = "$fieldName is required";
            return false;
        }

        // Remove common formatting characters
        $cleanPhone = preg_replace('/[\s\-\(\)\+]/', '', $phone);

        if (!preg_match('/^\d{10,15}$/', $cleanPhone)) {
            $this->errors[] = "$fieldName must be a valid phone number (10-15 digits)";
            return false;
        }

        return true;
    }

    /**
     * Validate file upload
     */
    public function validateFile($file, $fieldName, $allowedTypes = [], $maxSize = 5242880)
    {
        if (!isset($file) || $file['error'] === UPLOAD_ERR_NO_FILE) {
            $this->errors[] = "$fieldName is required";
            return false;
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $this->errors[] = "Error uploading $fieldName";
            return false;
        }

        // Check file size
        if ($file['size'] > $maxSize) {
            $maxSizeMB = $maxSize / (1024 * 1024);
            $this->errors[] = "$fieldName must not exceed {$maxSizeMB}MB";
            return false;
        }

        // Check file type
        if (!empty($allowedTypes)) {
            $fileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $mimeType = mime_content_type($file['tmp_name']);

            if (!in_array($fileExt, $allowedTypes)) {
                $this->errors[] = "$fieldName must be one of: " . implode(', ', $allowedTypes);
                return false;
            }

            // Verify PDF mime type
            if ($fileExt === 'pdf' && $mimeType !== 'application/pdf') {
                $this->errors[] = "$fieldName must be a valid PDF file";
                return false;
            }
        }

        return true;
    }

    /**
     * Validate integer
     */
    public function validateInteger($value, $fieldName, $min = null, $max = null)
    {
        if (!is_numeric($value) || $value != (int)$value) {
            $this->errors[] = "$fieldName must be a valid number";
            return false;
        }

        $value = (int)$value;

        if ($min !== null && $value < $min) {
            $this->errors[] = "$fieldName must be at least $min";
            return false;
        }

        if ($max !== null && $value > $max) {
            $this->errors[] = "$fieldName must not exceed $max";
            return false;
        }

        return true;
    }

    /**
     * Sanitize string input
     */
    public function sanitizeString($value)
    {
        return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Sanitize email
     */
    public function sanitizeEmail($email)
    {
        return filter_var(trim($email), FILTER_SANITIZE_EMAIL);
    }

    /**
     * Get all validation errors
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Check if there are any errors
     */
    public function hasErrors()
    {
        return !empty($this->errors);
    }

    /**
     * Get first error
     */
    public function getFirstError()
    {
        return $this->hasErrors() ? $this->errors[0] : null;
    }

    /**
     * Clear all errors
     */
    public function clearErrors()
    {
        $this->errors = [];
    }
}
