<?php

require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/ProductController.php';

require_admin();
post_only();

$categoryName = post_text('cat_name');

if ($categoryName === '') {
    $_SESSION['error'] = 'Category name is required.';
    redirect('views/admin/category.php');
}

try {
    $controller = new ProductController();
    $controller->addCategory($categoryName);

    $_SESSION['success'] = 'Category added.';
} catch (PDOException $exception) {
    error_log($exception->getMessage());
    $_SESSION['error'] = 'Category could not be added.';
}

redirect('views/admin/category.php');