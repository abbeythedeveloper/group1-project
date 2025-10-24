<?php
// lib/validation.php
// Handles input validation and sanitization across the app

/**
 * Sanitize text inputs (remove HTML tags and extra spaces)
 */
function sanitize_input($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

/**
 * Validate required fields
 */
function validate_required($fields) {
    $errors = [];
    foreach ($fields as $key => $value) {
        if (empty($value)) {
            $errors[] = ucfirst($key) . " is required.";
        }
    }
    return $errors;
}

/**
 * Validate email format
 */
function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Validate positive numbers (for total copies, etc.)
 */
function validate_positive_number($num) {
    return is_numeric($num) && $num > 0;
}

/**
 * Central validation handler
 */
function validate_book($title, $author, $copies) {
    $errors = validate_required(['title' => $title, 'author' => $author, 'total copies' => $copies]);
    if (!validate_positive_number($copies)) {
        $errors[] = "Total copies must be a positive number.";
    }
    return $errors;
}

function validate_borrower($name, $email, $phone) {
    $errors = validate_required(['name' => $name]);
    if ($email && !validate_email($email)) {
        $errors[] = "Invalid email address.";
    }
    return $errors;
}
?>
