<?php
require_once __DIR__ . '/../classes/ProductClass.php';

class ProductController
{
    public function addBrand($name)
    {
    $model = new ProductClass();
    return $model->addBrand($name);
    }

    public function getAllBrands()
    {
    $model = new ProductClass();
    return $model->getAllBrands();
    }

    public function getBrandById($id)
    {
    $model = new ProductClass();
    return $model->getBrandById($id);
    }

    public function updateBrand($id, $name)
    {
    $model = new ProductClass();
    return $model->updateBrand($id, $name);
    }

    public function addCategory($name)
    {
    $model = new ProductClass();
    return $model->addCategory($name);
    }

    public function getAllCategories()
    {
    $model = new ProductClass();
    return $model->getAllCategories();
    }

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
    public function getCategoryById($id)
    {
    $model = new ProductClass();
    return $model->getCategoryById($id);
    }

    public function updateCategory($id, $name)
    {
    $model = new ProductClass();
    return $model->updateCategory($id, $name);
    }


    public function addProduct($cat, $brand, $title, $price, $desc, $image, $keywords)
    {
    $model = new ProductClass();

    return $model->addProduct(
        $cat,
        $brand,
        $title,
        $price,
        $desc,
        $image,
        $keywords
    );
    }

    public function updateProduct($id, $cat, $brand, $title, $price, $desc, $image, $keywords)
    {
    $model = new ProductClass();

    return $model->updateProduct(
        $id,
        $cat,
        $brand,
        $title,
        $price,
        $desc,
        $image,
        $keywords
    );
    }

    public function getProductById($id)
    {
    $model = new ProductClass();

    return $model->getProductById($id);
    }

    public function getAllProducts()
    {
    $model = new ProductClass();

    return $model->getAllProducts();
    }




    public function getFeaturedProducts($n)
{
    $model = new ProductClass();

    return $model->getFeaturedProducts($n);
}

public function getProductsByCategory($cat)
{
    $model = new ProductClass();

    return $model->getProductsByCategory($cat);
}

public function getProductsByBrand($brand)
{
    $model = new ProductClass();

    return $model->getProductsByBrand($brand);
}

public function searchProducts($q)
{
    $model = new ProductClass();

    return $model->searchProducts($q);
}



}
