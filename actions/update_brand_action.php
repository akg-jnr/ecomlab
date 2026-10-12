    <?php

require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/ProductController.php';

require_admin();
post_only();

$brandId = filter_input(INPUT_POST, 'brand_id', FILTER_VALIDATE_INT);
$brandName = post_text('brand_name');

if (!$brandId || $brandId < 1) {
    $_SESSION['error'] = 'Invalid brand ID.';
    redirect('views/admin/brand.php');
}

if ($brandName === '') {
    $_SESSION['error'] = 'Brand name is required.';
    redirect('views/admin/brand.php?edit_id=' . $brandId);
}

try {
    $controller = new ProductController();
    $controller->updateBrand($brandId, $brandName);

    $_SESSION['success'] = 'Brand updated.';
} catch (PDOException $exception) {
    error_log($exception->getMessage());
    $_SESSION['error'] = 'Brand could not be updated.';
}

redirect('views/admin/brand.php');