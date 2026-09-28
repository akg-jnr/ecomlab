<?php
require_once __DIR__ . '/../../core/core.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? 'Ecom Lab') ?></title>
    <link rel="stylesheet" href="<?= e(url('css/style.css')) ?>">
    <script src="<?= e(url('js/customer.js')) ?>" defer></script>
    <script src="<?= e(url('js/validate.js')) ?>" defer></script>
</head>
<body>
<header>
    <h1>Ecom Lab</h1>
    <nav aria-label="Main navigation">
        <a href="<?= e(url('index.php')) ?>">Home</a>
        <?php if (is_logged_in()): ?>
            | Welcome <?= e($_SESSION['customer_name']) ?>
            | <a href="<?= e(url('views/account/my_account.php')) ?>">My Account</a>
            <?php if (is_admin()): ?>
                | <a href="<?= e(url('views/admin/index.php')) ?>">Admin</a>
                | <a href="<?= e(url('views/customers.php')) ?>">View All Customers</a>
            <?php endif; ?>
            <form action="<?= e(url('logout.php')) ?>" method="post">
                <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
                <button type="submit">Logout</button>
            </form>
        <?php else: ?>
            | <a href="<?= e(url('views/register.php')) ?>">Register</a>
            | <a href="<?= e(url('views/login.php')) ?>">Login</a>
        <?php endif; ?>
    </nav>
    <p>
        <label for="store-search">Search products</label>
        <input id="store-search" type="search" disabled placeholder="Available in Task 10">
    </p>
    <hr>
</header>
<?php foreach (['error', 'success'] as $messageType): ?>
    <?php if (isset($_SESSION[$messageType])): ?>
        <p role="<?= $messageType === 'error' ? 'alert' : 'status' ?>">
            <?= e($_SESSION[$messageType]) ?>
        </p>
        <?php unset($_SESSION[$messageType]); ?>
    <?php endif; ?>
<?php endforeach; ?>
<main>
