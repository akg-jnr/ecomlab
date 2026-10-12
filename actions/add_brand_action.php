<?php

require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/ProductController.php';

require_admin();
post_only();

$brandName = post_text('brand_name');

if ($brandName === '') {
    $_SESSION['error'] = 'Brand name is required.';
    redirect('views/admin/brand.php');
}

try {
    $controller = new ProductController();
    $controller->addBrand($brandName);

    $_SESSION['success'] = 'Brand added.';
} catch (PDOException $exception) {
    error_log($exception->getMessage());
    $_SESSION['error'] = 'Brand could not be added.';
}

redirect('views/admin/brand.php');