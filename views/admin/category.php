<?php

require_once __DIR__ . '/../../core/core.php';
require_once __DIR__ . '/../../controllers/ProductController.php';

require_admin();

$controller = new ProductController();
$editCategory = null;

$editId = filter_input(
    INPUT_GET,
    'edit_id',
    FILTER_VALIDATE_INT
);

if ($editId && $editId > 0) {
    $editCategory =
        $controller->getCategoryById($editId);
}

try {
    $categories = $controller->getAllCategories();
} catch (PDOException $exception) {
    error_log($exception->getMessage());
    $categories = [];
    $_SESSION['error'] = 'Categories could not be loaded.';
}

$pageTitle = 'Manage Categories';

require __DIR__ . '/../layout/header.php';
?>

<h2>Manage Categories</h2>

<?php if (isset($_SESSION['success'])): ?>
    <p><?= e($_SESSION['success']) ?></p>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <p><?= e($_SESSION['error']) ?></p>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<?php if ($editCategory): ?>

    <h3>Edit Category</h3>

    <form
        action="<?= e(url('actions/update_category_action.php')) ?>"
        method="post"
    >

        <input
            type="hidden"
            name="cat_id"
            value="<?= e($editCategory['cat_id']) ?>"
        >

        <label for="cat_name">Category Name</label><br>

        <input
            type="text"
            id="cat_name"
            name="cat_name"
            value="<?= e($editCategory['cat_name']) ?>"
            required
        >

        <br>

        <button type="submit">Update Category</button>

        <a href="<?= e(url('views/admin/category.php')) ?>">
            Cancel
        </a>

    </form>

<?php else: ?>

    <h3>Add Category</h3>

    <form
        action="<?= e(url('actions/add_category_action.php')) ?>"
        method="post"
    >

        <label for="cat_name">Category Name</label><br>

        <input
            type="text"
            id="cat_name"
            name="cat_name"
            required
        >

        <br>

        <button type="submit">Add Category</button>

    </form>

<?php endif; ?>

<h3>Existing Categories</h3>

<table border="1" cellpadding="5">

    <thead>
        <tr>
            <th>ID</th>
            <th>Category Name</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>

        <?php foreach ($categories as $category): ?>

            <tr>

                <td><?= e($category['cat_id']) ?></td>

                <td><?= e($category['cat_name']) ?></td>

                <td>
                    <a href="<?= e(url('views/admin/category.php?edit_id=' . $category['cat_id'])) ?>">
                        Edit
                    </a>
                </td>

            </tr>

        <?php endforeach; ?>

    </tbody>

</table>

<?php require __DIR__ . '/../layout/footer.php'; ?>