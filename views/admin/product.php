<?php

require_once __DIR__ . '/../../core/core.php';
require_once __DIR__ . '/../../controllers/ProductController.php';

require_admin();

$controller = new ProductController();

$editProduct = null;

$editId = filter_input(
    INPUT_GET,
    'edit_id',
    FILTER_VALIDATE_INT
);

if ($editId && $editId > 0) {
    $editProduct = $controller->getProductById($editId);
}

try {
    $categories = $controller->getAllCategories();
    $brands = $controller->getAllBrands();
    $products = $controller->getAllProducts();

} catch (PDOException $exception) {
    error_log($exception->getMessage());

    $categories = [];
    $brands = [];
    $products = []; 

    $_SESSION['error'] = 'Categories and brands could not be loaded.';
}

$pageTitle = 'Manage Products';

require __DIR__ . '/../layout/header.php';
?>

<h2>Manage Products</h2>

<?php if (isset($_SESSION['success'])): ?>
    <p role="status">
        <?= e($_SESSION['success']) ?>
    </p>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <p role="alert">
        <?= e($_SESSION['error']) ?>
    </p>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<?php if ($editProduct): ?>

    <h3>Edit Product</h3>

    <form
        action="<?= e(url('actions/update_product.php')) ?>"
        method="post"
        enctype="multipart/form-data"
    >

        <input
            type="hidden"
            name="product_id"
            value="<?= e($editProduct['product_id']) ?>"
        >

        <label for="product_cat">Category</label><br>

        <select id="product_cat" name="product_cat" required>
            <option value="">Choose a category</option>

            <?php foreach ($categories as $category): ?>
                <option
                    value="<?= e($category['cat_id']) ?>"
                    <?= $editProduct['product_cat'] == $category['cat_id'] ? 'selected' : '' ?>
                >
                    <?= e($category['cat_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <br>

        <label for="product_brand">Brand</label><br>

        <select id="product_brand" name="product_brand" required>
            <option value="">Choose a brand</option>

            <?php foreach ($brands as $brand): ?>
                <option
                    value="<?= e($brand['brand_id']) ?>"
                    <?= $editProduct['product_brand'] == $brand['brand_id'] ? 'selected' : '' ?>
                >
                    <?= e($brand['brand_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <br>

        <label for="product_title">Product Title</label><br>

        <input
            type="text"
            id="product_title"
            name="product_title"
            value="<?= e($editProduct['product_title']) ?>"
            required
        >

        <br>

        <label for="product_price">Price</label><br>

        <input
            type="number"
            id="product_price"
            name="product_price"
            step="0.01"
            min="0"
            value="<?= e($editProduct['product_price']) ?>"
            required
        >

        <br>

        <label for="product_desc">Description</label><br>

        <textarea
            id="product_desc"
            name="product_desc"
            required
        ><?= e($editProduct['product_desc']) ?></textarea>

        <br>

        <label>Current Image</label><br>

        <?php if (!empty($editProduct['product_image'])): ?>
            <p><?= e($editProduct['product_image']) ?></p>
        <?php endif; ?>

        <label for="product_image">New Image (optional)</label><br>

        <input
            type="file"
            id="product_image"
            name="product_image"
            accept=".jpg,.jpeg,.png,.gif,.webp"
        >

        <br>

        <label for="product_keywords">Keywords</label><br>

        <input
            type="text"
            id="product_keywords"
            name="product_keywords"
            value="<?= e($editProduct['product_keywords']) ?>"
            required
        >

        <br>

        <button type="submit">Update Product</button>

        <a href="<?= e(url('views/admin/product.php')) ?>">
            Cancel
        </a>

    </form>

<?php else: ?>

    <h3>Add Product</h3>

    <form
        action="<?= e(url('actions/add_product.php')) ?>"
        method="post"
        enctype="multipart/form-data"
    >

        <label for="product_cat">Category</label><br>

        <select id="product_cat" name="product_cat" required>
            <option value="">Choose a category</option>

            <?php foreach ($categories as $category): ?>
                <option value="<?= e($category['cat_id']) ?>">
                    <?= e($category['cat_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <br>

        <label for="product_brand">Brand</label><br>

        <select id="product_brand" name="product_brand" required>
            <option value="">Choose a brand</option>

            <?php foreach ($brands as $brand): ?>
                <option value="<?= e($brand['brand_id']) ?>">
                    <?= e($brand['brand_name']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <br>

        <label for="product_title">Product Title</label><br>

        <input
            type="text"
            id="product_title"
            name="product_title"
            required
        >

        <br>

        <label for="product_price">Price</label><br>

        <input
            type="number"
            id="product_price"
            name="product_price"
            step="0.01"
            min="0"
            required
        >

        <br>

        <label for="product_desc">Description</label><br>

        <textarea
            id="product_desc"
            name="product_desc"
            required
        ></textarea>

        <br>

        <label for="product_image">Product Image</label><br>

        <input
            type="file"
            id="product_image"
            name="product_image"
            accept=".jpg,.jpeg,.png,.gif,.webp"
            required
        >

        <br>

        <label for="product_keywords">Keywords</label><br>

        <input
            type="text"
            id="product_keywords"
            name="product_keywords"
            required
        >

        <br>

        <button type="submit">Add Product</button>

    </form>

<?php endif; ?>

<h3>Existing Products</h3>

<table border="1" cellpadding="5">

    <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Category</th>
            <th>Brand</th>
            <th>Price</th>
            <th>Image</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>

        <?php foreach ($products as $product): ?>

            <tr>

                <td>
                    <?= e($product['product_id']) ?>
                </td>

                <td>
                    <?= e($product['product_title']) ?>
                </td>

                <td>
                    <?= e($product['cat_name']) ?>
                </td>

                <td>
                    <?= e($product['brand_name']) ?>
                </td>

                <td>
                    <?= e($product['product_price']) ?>
                </td>

                <td>
                    <?= e($product['product_image']) ?>
                </td>

                <td>
                    <a href="<?= e(
                        url(
                            'views/admin/product.php?edit_id='
                            . $product['product_id']
                        )
                    ) ?>">
                        Edit
                    </a>
                </td>

            </tr>

        <?php endforeach; ?>

    </tbody>

</table>