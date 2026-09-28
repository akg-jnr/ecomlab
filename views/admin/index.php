<?php
require_once __DIR__ . '/../../core/core.php';
require_admin(); // Demonstrates Task 4 access control;
$pageTitle = 'Admin Access Check';
require __DIR__ . '/../layout/header.php';
?>
<h2>Admin Access Check</h2>
<p>You have administrator access. Brand, category and product tools come in later tasks.</p>
<?php require __DIR__ . '/../layout/footer.php'; ?>
