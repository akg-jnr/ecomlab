<?php
require_once __DIR__ . '/../../controllers/ProductController.php';
$productController = new ProductController();
$sidebar = $productController->getSidebarData();
?>
<aside aria-label="Store categories and brands">
    <?php if ($sidebar['error']): ?>
        <p role="alert"><?= e($sidebar['error']) ?></p>
    <?php else: ?>
        <h2>Categories</h2>
        <?php if (!$sidebar['categories']): ?><p>No categories added yet.</p><?php endif; ?>
        <ul>
        <?php foreach ($sidebar['categories'] as $category): ?>
            <li><?= e($category['cat_name']) ?></li>
        <?php endforeach; ?>
        </ul>
        <h2>Brands</h2>
        <?php if (!$sidebar['brands']): ?><p>No brands added yet.</p><?php endif; ?>
        <ul>
        <?php foreach ($sidebar['brands'] as $brand): ?>
            <li><?= e($brand['brand_name']) ?></li>
        <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</aside>
