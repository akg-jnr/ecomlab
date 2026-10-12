<?php

require_once __DIR__ . '/../../core/core.php';
require_once __DIR__ . '/../../controllers/ProductController.php';

require_admin();

$controller = new ProductController();
$editBrand = null;

$editId = filter_input(INPUT_GET, 'edit_id', FILTER_VALIDATE_INT);

if ($editId && $editId > 0) {
    $editBrand = $controller->getBrandById($editId);
}

try {
    $brands = $controller->getAllBrands();
} catch (PDOException $exception) {
    error_log($exception->getMessage());
    $brands = [];
    $_SESSION['error'] = 'Brands could not be loaded.';
}

$pageTitle = 'Manage Brands';

require __DIR__ . '/../layout/header.php';
?>

<h2>Manage Brands</h2>

<?php if (isset($_SESSION['success'])): ?>
    <p><?= e($_SESSION['success']) ?></p>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <p><?= e($_SESSION['error']) ?></p>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<?php if ($editBrand): ?>

    <h3>Edit Brand</h3>

    <form action="<?= e(url('actions/update_brand_action.php')) ?>" method="post">

        <input
            type="hidden"
            name="brand_id"
            value="<?= e($editBrand['brand_id']) ?>"
        >

        <label for="brand_name">Brand Name</label><br>

        <input
            type="text"
            id="brand_name"
            name="brand_name"
            value="<?= e($editBrand['brand_name']) ?>"
            required
        >

        <br>

        <button type="submit">Update Brand</button>

        <a href="<?= e(url('views/admin/brand.php')) ?>">Cancel</a>

    </form>

<?php else: ?>

    <h3>Add Brand</h3>

    <form action="<?= e(url('actions/add_brand_action.php')) ?>" method="post">

        <label for="brand_name">Brand Name</label><br>

        <input
            type="text"
            id="brand_name"
            name="brand_name"
            required
        >

        <br>

        <button type="submit">Add Brand</button>

    </form>

<?php endif; ?>

<h3>Existing Brands</h3>

<table border="1" cellpadding="5">
    <thead>
        <tr>
            <th>ID</th>
            <th>Brand Name</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($brands as $brand): ?>
            <tr>
                <td><?= e($brand['brand_id']) ?></td>
                <td><?= e($brand['brand_name']) ?></td>
                <td>
                    <a href="<?= e(url('views/admin/brand.php?edit_id=' . $brand['brand_id'])) ?>">
                        Edit
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require __DIR__ . '/../layout/footer.php'; ?>