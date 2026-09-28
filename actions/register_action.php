<?php
require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/CustomerController.php';
post_only();
check_csrf('views/register.php');

$data = [];
foreach (['name', 'email', 'country', 'city', 'contact', 'address'] as $field) {
    $data[$field] = post_text('customer_' . $field);
}

$_SESSION['old'] = $data;
$data['password'] = post_password();
$controller = new CustomerController();
$result = $controller->register($data);

if ($result['success']) {
    sign_in($result['customer']);
    $_SESSION['success'] = 'Your account has been created.';
    redirect('views/account/my_account.php');
}
$_SESSION['error'] = $result['error'];
redirect('views/register.php');
