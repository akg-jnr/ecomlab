<?php
require_once __DIR__ . '/../core/core.php';
if (is_logged_in()) { redirect('views/account/my_account.php'); }
$old = $_SESSION['old'] ?? [];
unset($_SESSION['old']);
$pageTitle = 'Create an Account';
require __DIR__ . '/layout/header.php';
?>
<h2>Create an Account</h2>
<p>All fields are required. Passwords need at least 8 characters and one digit.</p>
<form id="register-form" action="<?= e(url('actions/register_action.php')) ?>" method="post" novalidate>
    <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
    <p>
        <label for="customer_name">Full Name</label><br>
        <input id="customer_name" name="customer_name" required minlength="2" maxlength="100" autocomplete="name"
               value="<?= e($old['name'] ?? '') ?>" aria-describedby="customer_name-error">
        <br><span id="customer_name-error" aria-live="polite"></span>
    </p>
    <p>
        <label for="customer_email">Email</label><br>
        <input id="customer_email" name="customer_email" type="email" required maxlength="50" autocomplete="email"
               value="<?= e($old['email'] ?? '') ?>" aria-describedby="customer_email-error">
        <br><span id="customer_email-error" aria-live="polite"></span>
    </p>
    <p>
        <label for="customer_pass">Password</label><br>
        <input id="customer_pass" name="customer_pass" type="password" required minlength="8" maxlength="72"
               autocomplete="new-password" aria-describedby="customer_pass-error">
        <br><span id="customer_pass-error" aria-live="polite"></span>
    </p>
    <p>
        <label for="customer_country">Country</label><br>
        <select id="customer_country" name="customer_country" required aria-describedby="customer_country-error">
            <option value="">Choose your country</option>
            <?php foreach (COUNTRIES as $country): ?>
                <option value="<?= e($country) ?>" <?= ($old['country'] ?? '') === $country ? 'selected' : '' ?>><?= e($country) ?></option>
            <?php endforeach; ?>
        </select>
        <br><span id="customer_country-error" aria-live="polite"></span>
    </p>
    <p>
        <label for="customer_city">City</label><br>
        <input id="customer_city" name="customer_city" required maxlength="30" autocomplete="address-level2"
               value="<?= e($old['city'] ?? '') ?>" aria-describedby="customer_city-error">
        <br><span id="customer_city-error" aria-live="polite"></span>
    </p>
    <p>
        <label for="customer_contact">Contact Number</label><br>
        <input id="customer_contact" name="customer_contact" type="tel" required maxlength="15" autocomplete="tel"
               value="<?= e($old['contact'] ?? '') ?>" aria-describedby="customer_contact-error">
        <br><span id="customer_contact-error" aria-live="polite"></span>
    </p>
    <p>
        <label for="customer_address">Address</label><br>
        <textarea id="customer_address" name="customer_address" required maxlength="255" autocomplete="street-address"
                  aria-describedby="customer_address-error"><?= e($old['address'] ?? '') ?></textarea>
        <br><span id="customer_address-error" aria-live="polite"></span>
    </p>
    <button type="submit">Create Account</button>
</form>
<p>Already registered? <a href="<?= e(url('views/login.php')) ?>">Log in</a>.</p>
<?php require __DIR__ . '/layout/footer.php'; ?>
