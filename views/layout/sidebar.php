<?php

require_once __DIR__ . '/../../controllers/ProductController.php';

$productController = new ProductController();
$sidebar = $productController->getSidebarData();

?>

<aside aria-label="Store categories and brands">

    <?php if ($sidebar['error']): ?>

        <p role="alert">
            <?= e($sidebar['error']) ?>
        </p>

    <?php else: ?>

        <h2>Categories</h2>

        <ul>
            <?php foreach ($sidebar['categories'] as $category): ?>
                <li>
                    <a href="<?= e(
                        url('index.php?cat=' . $category['cat_id'])
                    ) ?>">
                        <?= e($category['cat_name']) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>

        <h2>Brands</h2>

        <ul>
            <?php foreach ($sidebar['brands'] as $brand): ?>
                <li>
                    <a href="<?= e(
                        url('index.php?brand=' . $brand['brand_id'])
                    ) ?>">
                        <?= e($brand['brand_name']) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>

    <?php endif; ?>

</aside>