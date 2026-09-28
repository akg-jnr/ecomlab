<?php
require_once __DIR__ . '/../core/core.php';
if (is_logged_in()) { redirect('index.php'); }
$pageTitle = 'Customer Login';
require __DIR__ . '/layout/header.php';
?>
<h2>Customer Login</h2>
<form id="login-form" action="<?= e(url('actions/login_action.php')) ?>" method="post" novalidate>
    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
    <p>
        <label for="customer_email">Email</label><br>
        <input id="customer_email" name="customer_email" type="email" required maxlength="50"
               autocomplete="username" aria-describedby="customer_email-error">
        <br><span id="customer_email-error" aria-live="polite"></span>
    </p>
    <p>
        <label for="customer_pass">Password</label><br>
        <input id="customer_pass" name="customer_pass" type="password" required maxlength="72"
               autocomplete="current-password" aria-describedby="customer_pass-error">
        <br><span id="customer_pass-error" aria-live="polite"></span>
    </p>
    <button type="submit">Login</button>
</form>
<p>Need an account? <a href="<?= e(url('views/register.php')) ?>">Register</a>.</p>
<?php require __DIR__ . '/layout/footer.php'; ?>
