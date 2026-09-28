<?php
require_once __DIR__ . '/../classes/ProductClass.php';

class ProductController
{
    public function getSidebarData()
    {
        try {
            $model = new ProductClass();
            return ['categories' => $model->getAllCategories(),
                'brands' => $model->getAllBrands(), 'error' => ''];
        } catch (PDOException $exception) {
            error_log($exception->getMessage());
            return ['categories' => [], 'brands' => [],
                'error' => 'The store database is unavailable. Check the import and connection settings.'];
        }
    }
}
