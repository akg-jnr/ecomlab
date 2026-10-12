<?php

require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/ProductController.php';

require_admin();
post_only();

$categoryId = filter_input(INPUT_POST, 'cat_id', FILTER_VALIDATE_INT);
$categoryName = post_text('cat_name');

if (!$categoryId || $categoryId < 1) {
    $_SESSION['error'] = 'Invalid category ID.';
    redirect('views/admin/category.php');
}

if ($categoryName === '') {
    $_SESSION['error'] = 'Category name is required.';
    redirect('views/admin/category.php?edit_id=' . $categoryId);
}

try {
    $controller = new ProductController();

    $controller->updateCategory(
        $categoryId,
        $categoryName
    );

    $_SESSION['success'] = 'Category updated.';
} catch (PDOException $exception) {

    error_log($exception->getMessage());

    $_SESSION['error'] =
        'Category could not be updated.';
}

redirect('views/admin/category.php');