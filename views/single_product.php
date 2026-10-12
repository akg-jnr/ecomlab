<?php

require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/ProductController.php';

$controller = new ProductController();

$productId = filter_input(
    INPUT_GET,
    'id',
    FILTER_VALIDATE_INT
);

if (!$productId || $productId < 1) {
    $_SESSION['error'] = 'Invalid product.';
    redirect('index.php');
}

try {

    $product = $controller->getProductById($productId);

    if (!$product) {
        $_SESSION['error'] = 'Product not found.';
        redirect('index.php');
    }

} catch (PDOException $exception) {

    error_log($exception->getMessage());

    $_SESSION['error'] = 'Product could not be loaded.';
    redirect('index.php');
}

$pageTitle = $product['product_title'];

require __DIR__ . '/layout/header.php';
?>

<h2>
    <?= e($product['product_title']) ?>
</h2>

<?php if (!empty($product['product_image'])): ?>

    <img
        src="<?= e(
            url(
                'images/products/' .
                $product['product_image']
            )
        ) ?>"
        alt="<?= e($product['product_title']) ?>"
        width="300"
    >

<?php endif; ?>

<p>
    <strong>Category:</strong>
    <?= e($product['cat_name']) ?>
</p>

<p>
    <strong>Brand:</strong>
    <?= e($product['brand_name']) ?>
</p>

<p>
    <strong>Price:</strong>
    <?= e($product['product_price']) ?>
</p>

<p>
    <strong>Description:</strong>
    <?= e($product['product_desc']) ?>
</p>

<p>
    <strong>Keywords:</strong>
    <?= e($product['product_keywords']) ?>
</p>

<p>
    <a href="<?= e(url('index.php')) ?>">
        Back to Products
    </a>
</p>