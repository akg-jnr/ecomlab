<?php
require_once __DIR__ . '/../../core/core.php';
require_login(); // Must run before the header outputs any HTML.
$pageTitle = 'My Account';
require __DIR__ . '/../layout/header.php';
?>
<h2>My Account</h2>
<dl>
    <dt>Name</dt><dd><?= e($_SESSION['customer_name']) ?></dd>
    <dt>Email</dt><dd><?= e($_SESSION['customer_email']) ?></dd>
    <dt>Account type</dt><dd><?= is_admin() ? 'Administrator' : 'Customer' ?></dd>
</dl>
<?php require __DIR__ . '/../layout/footer.php'; ?>
