<?php
session_start();

date_default_timezone_set('UTC');

define('APP_NAME', 'ReadReady Dictionary and Nursery Learning System');
define('APP_BASE_URL', '/readready');
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'readready_db');

function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function sanitize_text($value)
{
    return trim(strip_tags((string) $value));
}

function csrf_token()
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function csrf_field()
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

function redirect($path)
{
    header('Location: ' . APP_BASE_URL . $path);
    exit;
}
