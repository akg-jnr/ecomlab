<?php
require_once __DIR__ . '/config.php';
date_default_timezone_set('Africa/Accra');
ob_start();
ini_set('log_errors', '1');
ini_set('display_errors', '0');
ini_set('error_log', __DIR__ . '/../error/error.log');

if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.use_strict_mode', '1');
    session_set_cookie_params([
        'httponly' => true,
        'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
        'samesite' => 'Lax',
        'path' => BASE_URL . '/',
    ]);
    session_start();
}

require_once __DIR__ . '/db_class.php';

function url($path = '')
{
    return BASE_URL . '/' . ltrim($path, '/');
}

function redirect($path)
{
    header('Location: ' . url($path), true, 303);
    exit;
}


function e($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function get_ip()
{
    return $_SERVER['REMOTE_ADDR'] ?? '';
}

function is_logged_in()
{
    return isset($_SESSION['customer_id']);
}

function is_admin()
{
    return is_logged_in() && ($_SESSION['user_role'] ?? null) === 1;
}

function require_login()
{
    if (!is_logged_in()) {
        $_SESSION['error'] = 'Please log in to open that page.';
        redirect('views/login.php');
    }
}

function require_admin()
{
    if (!is_admin()) {
        $_SESSION['error'] = 'Only an administrator can open that page.';
        redirect('index.php');
    }
}

function post_only()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        header('Allow: POST');
        exit;
    }
}

// The token ties a submitted form to this browser's session.
function csrf_token()
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function check_csrf($returnPage)
{
    $token = $_POST['csrf_token'] ?? '';
    if (!is_string($token) || !hash_equals(csrf_token(), $token)) {
        $_SESSION['error'] = 'Your form expired. Please try again.';
        redirect($returnPage);
    }
}

function sign_in($customer)
{
    session_regenerate_id(true);
    $_SESSION['customer_id'] = (int) $customer['customer_id'];
    $_SESSION['customer_name'] = $customer['customer_name'];
    $_SESSION['customer_email'] = $customer['customer_email'];
    $_SESSION['user_role'] = (int) $customer['user_role'];
    unset($_SESSION['csrf_token'], $_SESSION['error'], $_SESSION['old']);
}

function post_text($name)
{
    $value = $_POST[$name] ?? '';
    return is_string($value) ? trim(strip_tags($value)) : '';
}

function post_password()
{
    $value = $_POST['customer_pass'] ?? '';
    return is_string($value) ? $value : ''; // Never trim or strip a password.
}


function core_get_user_id()
{
    return $_SESSION['customer_id'] ?? null;
}

function core_get_user_role()
{
    return $_SESSION['user_role'] ?? null;
}
