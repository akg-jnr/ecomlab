<?php

require_once __DIR__ . '/../core/core.php';
require_once __DIR__ . '/../controllers/ProductController.php';

require_admin();
post_only();

$cat = filter_input(INPUT_POST, 'product_cat', FILTER_VALIDATE_INT);
$brand = filter_input(INPUT_POST, 'product_brand', FILTER_VALIDATE_INT);

$title = post_text('product_title');
$price = post_text('product_price');
$desc = post_text('product_desc');
$keywords = post_text('product_keywords');

if (!$cat || $cat < 1) {
    $_SESSION['error'] = 'Please choose a valid category.';
    redirect('views/admin/product.php');
}

if (!$brand || $brand < 1) {
    $_SESSION['error'] = 'Please choose a valid brand.';
    redirect('views/admin/product.php');
}

if ($title === '') {
    $_SESSION['error'] = 'Product title is required.';
    redirect('views/admin/product.php');
}

if ($price === '' || !is_numeric($price) || $price < 0) {
    $_SESSION['error'] = 'Please enter a valid product price.';
    redirect('views/admin/product.php');
}

if ($desc === '') {
    $_SESSION['error'] = 'Product description is required.';
    redirect('views/admin/product.php');
}

if ($keywords === '') {
    $_SESSION['error'] = 'Product keywords are required.';
    redirect('views/admin/product.php');
}

if (
    !isset($_FILES['product_image']) ||
    $_FILES['product_image']['error'] !== UPLOAD_ERR_OK
) {
    $_SESSION['error'] = 'Please upload a product image.';
    redirect('views/admin/product.php');
}

$file = $_FILES['product_image'];

$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

$extension = strtolower(
    pathinfo($file['name'], PATHINFO_EXTENSION)
);

if (!in_array($extension, $allowedExtensions, true)) {
    $_SESSION['error'] = 'Image must be JPG, JPEG, PNG, GIF or WEBP.';
    redirect('views/admin/product.php');
}

if ($file['size'] > 5 * 1024 * 1024) {
    $_SESSION['error'] = 'Image must be smaller than 5MB.';
    redirect('views/admin/product.php');
}

$filename = uniqid('prod_', true) . '.' . $extension;

$uploadFolder = __DIR__ . '/../images/products/';

if (!is_dir($uploadFolder)) {
    mkdir($uploadFolder, 0755, true);
}

$destination = $uploadFolder . $filename;

if (!move_uploaded_file($file['tmp_name'], $destination)) {
    $_SESSION['error'] = 'Product image could not be uploaded.';
    redirect('views/admin/product.php');
}

try {
    $controller = new ProductController();

    $controller->addProduct(
        $cat,
        $brand,
        $title,
        $price,
        $desc,
        $filename,
        $keywords
    );

    $_SESSION['success'] = 'Product added.';
} catch (PDOException $exception) {
    error_log($exception->getMessage());

    $_SESSION['error'] = 'Product could not be added.';
}

redirect('views/admin/product.php');