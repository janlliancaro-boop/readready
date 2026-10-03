<?php
session_start();

date_default_timezone_set('UTC');

define('APP_NAME', 'ReadReady Dictionary and Nursery Learning System');
define('APP_BASE_URL', '/readready');
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'readready_db');
define('ADMIN_DEFAULT_USERNAME', 'admin');
define('ADMIN_DEFAULT_PASSWORD', 'admin123');

function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function sanitize_text($value): string
{
    return trim(strip_tags((string) $value));
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

function redirect($path): void
{
    header('Location: ' . APP_BASE_URL . $path);
    exit;
}

function generate_token(int $length = 32): string
{
    return bin2hex(random_bytes((int) ceil($length / 2)));
}

function is_admin_logged_in(): bool
{
    return !empty($_SESSION['admin_id']);
}

function is_learner_logged_in(): bool
{
    return !empty($_SESSION['learner_id']) && !empty($_SESSION['learner_token']);
}
