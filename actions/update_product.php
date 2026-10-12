<?php

require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/ProductController.php';

require_admin();
post_only();

$productId = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
$cat = filter_input(INPUT_POST, 'product_cat', FILTER_VALIDATE_INT);
$brand = filter_input(INPUT_POST, 'product_brand', FILTER_VALIDATE_INT);

$title = post_text('product_title');
$price = post_text('product_price');
$desc = post_text('product_desc');
$keywords = post_text('product_keywords');

if (!$productId || $productId < 1) {
    $_SESSION['error'] = 'Invalid product ID.';
    redirect('views/admin/product.php');
}

if (!$cat || $cat < 1) {
    $_SESSION['error'] = 'Please choose a valid category.';
    redirect('views/admin/product.php?edit_id=' . $productId);
}

if (!$brand || $brand < 1) {
    $_SESSION['error'] = 'Please choose a valid brand.';
    redirect('views/admin/product.php?edit_id=' . $productId);
}

if ($title === '') {
    $_SESSION['error'] = 'Product title is required.';
    redirect('views/admin/product.php?edit_id=' . $productId);
}

if ($price === '' || !is_numeric($price) || $price < 0) {
    $_SESSION['error'] = 'Please enter a valid product price.';
    redirect('views/admin/product.php?edit_id=' . $productId);
}

if ($desc === '') {
    $_SESSION['error'] = 'Product description is required.';
    redirect('views/admin/product.php?edit_id=' . $productId);
}

if ($keywords === '') {
    $_SESSION['error'] = 'Product keywords are required.';
    redirect('views/admin/product.php?edit_id=' . $productId);
}

try {
    $controller = new ProductController();

    $product = $controller->getProductById($productId);

    if (!$product) {
        $_SESSION['error'] = 'Product not found.';
        redirect('views/admin/product.php');
    }

    $imageName = $product['product_image'];

    if (
        isset($_FILES['product_image']) &&
        $_FILES['product_image']['error'] === UPLOAD_ERR_OK
    ) {
        $file = $_FILES['product_image'];

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        $extension = strtolower(
            pathinfo($file['name'], PATHINFO_EXTENSION)
        );

        if (!in_array($extension, $allowedExtensions, true)) {
            $_SESSION['error'] = 'Image must be JPG, JPEG, PNG, GIF or WEBP.';
            redirect('views/admin/product.php?edit_id=' . $productId);
        }

        if ($file['size'] > 5 * 1024 * 1024) {
            $_SESSION['error'] = 'Image must be smaller than 5MB.';
            redirect('views/admin/product.php?edit_id=' . $productId);
        }

        $imageName = uniqid('prod_', true) . '.' . $extension;

        $uploadFolder = __DIR__ . '/../images/products/';

        if (!is_dir($uploadFolder)) {
            mkdir($uploadFolder, 0755, true);
        }

        $destination = $uploadFolder . $imageName;

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            $_SESSION['error'] = 'New product image could not be uploaded.';
            redirect('views/admin/product.php?edit_id=' . $productId);
        }
    }

    $controller->updateProduct(
        $productId,
        $cat,
        $brand,
        $title,
        $price,
        $desc,
        $imageName,
        $keywords
    );

    $_SESSION['success'] = 'Product updated.';
} catch (PDOException $exception) {
    error_log($exception->getMessage());

    $_SESSION['error'] = 'Product could not be updated.';
}

redirect('views/admin/product.php');