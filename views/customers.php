<?php
require_once __DIR__ . '/../core/core.php';
require_admin(); // Customer contact details are only listed for administrators.
require_once __DIR__ . '/../functions/customer_functions.php';
$customers = [];
$listError = '';
try {
    $customers = getAllCustomersList();
} catch (PDOException $exception) {
    error_log($exception->getMessage());
    $listError = 'Customer list unavailable. Check the database setup and error log.';
}
$pageTitle = 'All Customers';
require __DIR__ . '/layout/header.php';
?>
<h2>All Customers</h2>
<?php if ($listError): ?><p role="alert"><?= e($listError) ?></p><?php endif; ?>
<?php if (!$listError && !$customers): ?><p>No customers registered yet.</p><?php endif; ?>
<table border="1" cellpadding="5" cellspacing="0">
    <thead>
        <tr><th>ID</th><th>Name</th><th>Email</th><th>Country</th><th>City</th><th>Contact</th></tr>
    </thead>
    <tbody>
    <?php foreach ($customers as $customer): ?>
        <tr>
            <td><?= e($customer['customer_id']) ?></td>
            <td><?= e($customer['customer_name']) ?></td>
            <td><?= e($customer['customer_email']) ?></td>
            <td><?= e($customer['customer_country']) ?></td>
            <td><?= e($customer['customer_city']) ?></td>
            <td><?= e($customer['customer_contact']) ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php require __DIR__ . '/layout/footer.php'; ?>
