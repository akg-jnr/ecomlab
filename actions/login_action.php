<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/CustomerController.php';
post_only();
check_csrf('views/login.php');

$controller = new CustomerController();
$result = $controller->login(post_text('customer_email'), post_password());
if ($result['success']) {
    sign_in($result['customer']);
    $_SESSION['success'] = 'You are now logged in.';
    redirect('index.php');
}
$_SESSION['error'] = $result['error'];
redirect('views/login.php');
