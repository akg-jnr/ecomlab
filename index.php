<?php

require_once __DIR__ . '/core/core.php';
require_once __DIR__ . '/controllers/ProductController.php';

$controller = new ProductController();

$products = [];
$pageHeading = 'Featured Products';

try {

    if (isset($_GET['q']) && trim($_GET['q']) !== '') {

        $searchTerm = trim($_GET['q']);

        $products = $controller->searchProducts($searchTerm);

        $pageHeading = 'Search Results for "' . $searchTerm . '"';

    } elseif (
        isset($_GET['cat']) &&
        filter_var($_GET['cat'], FILTER_VALIDATE_INT)
    ) {

        $categoryId = (int) $_GET['cat'];

        $products = $controller->getProductsByCategory($categoryId);

        $pageHeading = 'Products by Category';

    } elseif (
        isset($_GET['brand']) &&
        filter_var($_GET['brand'], FILTER_VALIDATE_INT)
    ) {

        $brandId = (int) $_GET['brand'];

        $products = $controller->getProductsByBrand($brandId);

        $pageHeading = 'Products by Brand';

    } else {

        $products = $controller->getFeaturedProducts(8);
    }

} catch (PDOException $exception) {

    error_log($exception->getMessage());

    $products = [];

    $_SESSION['error'] = 'Products could not be loaded.';
}

$pageTitle = 'Shop';

require __DIR__ . '/views/layout/header.php';
?>

<?php require __DIR__ . '/views/layout/sidebar.php'; ?>

<h2><?= e($pageHeading) ?></h2>
<?php if (empty($products)): ?>

    <p>No products found.</p>

<?php else: ?>

    <?php foreach ($products as $product): ?>

        <div>

            <h3>
                <?= e($product['product_title']) ?>
            </h3>

            <?php if (!empty($product['product_image'])): ?>

                <img
                    src="<?= e(
                        url(
                            'images/products/' .
                            $product['product_image']
                        )
                    ) ?>"
                    alt="<?= e($product['product_title']) ?>"
                    width="200"
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
                <?= e($product['product_desc']) ?>
            </p>

            <a href="<?= e(
                url(
                    'views/single_product.php?id=' .
                    $product['product_id']
                )
            ) ?>">
                View Product
            </a>

        </div>

        <hr>

    <?php endforeach; ?>

<?php endif; ?>