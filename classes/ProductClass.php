<?php
require_once __DIR__ . '/../core/db_class.php';


class ProductClass extends Database
{
    public function getAllCategories()
    {
        return $this->fetchAll('SELECT cat_id, cat_name FROM categories ORDER BY cat_name');
    }

    public function getAllBrands()  
    {
        return $this->fetchAll('SELECT brand_id, brand_name FROM brands ORDER BY brand_name');
    }

    public function addBrand($name)
    {
    $sql = "INSERT INTO brands (brand_name) VALUES (?)";
    return $this->execute($sql, [$name]);
    }

    public function getBrandById($id)
    {
    $sql = "SELECT * FROM brands WHERE brand_id = ?";
    return $this->fetchOne($sql, [$id]);
    }

    public function updateBrand($id, $name)
    {
    $sql = "UPDATE brands SET brand_name = ? WHERE brand_id = ?";
    return $this->execute($sql, [$name, $id]);
    }

    public function addCategory($name)
    {
    $sql = "INSERT INTO categories (cat_name) VALUES (?)";
    return $this->execute($sql, [$name]);
    }

    public function getCategoryById($id)
{
    $sql = "SELECT * FROM categories WHERE cat_id = ?";
    return $this->fetchOne($sql, [$id]);
}

    public function updateCategory($id, $name)
    {
    $sql = "UPDATE categories SET cat_name = ? WHERE cat_id = ?";
    return $this->execute($sql, [$name, $id]);
    }

    public function addProduct($cat, $brand, $title, $price, $desc, $image, $keywords)
    {
    $sql = "INSERT INTO products (
                product_cat,
                product_brand,
                product_title,
                product_price,
                product_desc,
                product_image,
                product_keywords
            )
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    return $this->execute(
        $sql,
        [$cat, $brand, $title, $price, $desc, $image, $keywords]
    );
    }


    public function updateProduct($id, $cat, $brand, $title, $price, $desc, $image, $keywords)
    {
    $sql = "UPDATE products
            SET product_cat = ?,
                product_brand = ?,
                product_title = ?,
                product_price = ?,
                product_desc = ?,
                product_image = ?,
                product_keywords = ?
            WHERE product_id = ?";

    return $this->execute(
        $sql,
        [$cat, $brand, $title, $price, $desc, $image, $keywords, $id]
    );
    }


    public function getProductById($id)
    {
    $sql = "SELECT
                products.*,
                categories.cat_name,
                brands.brand_name
            FROM products
            JOIN categories
                ON products.product_cat = categories.cat_id
            JOIN brands
                ON products.product_brand = brands.brand_id
            WHERE products.product_id = ?";

    return $this->fetchOne($sql, [$id]);
    }


    public function getAllProducts()
    {
    $sql = "SELECT
                products.*,
                categories.cat_name,
                brands.brand_name
            FROM products
            JOIN categories
                ON products.product_cat = categories.cat_id
            JOIN brands
                ON products.product_brand = brands.brand_id
            ORDER BY products.product_id DESC";

    return $this->fetchAll($sql);
    }



    public function getFeaturedProducts($n)
    {
    $sql = "SELECT
                products.*,
                categories.cat_name,
                brands.brand_name
            FROM products
            JOIN categories
                ON products.product_cat = categories.cat_id
            JOIN brands
                ON products.product_brand = brands.brand_id
            ORDER BY products.product_id DESC
            LIMIT ?";

    return $this->fetchAll($sql, [$n]);
    }


    public function getProductsByCategory($cat)
    {
    $sql = "SELECT
                products.*,
                categories.cat_name,
                brands.brand_name
            FROM products
            JOIN categories
                ON products.product_cat = categories.cat_id
            JOIN brands
                ON products.product_brand = brands.brand_id
            WHERE products.product_cat = ?
            ORDER BY products.product_id DESC";

    return $this->fetchAll($sql, [$cat]);
    }


    public function getProductsByBrand($brand)
    {
    $sql = "SELECT
                products.*,
                categories.cat_name,
                brands.brand_name
            FROM products
            JOIN categories
                ON products.product_cat = categories.cat_id
            JOIN brands
                ON products.product_brand = brands.brand_id
            WHERE products.product_brand = ?
            ORDER BY products.product_id DESC";

    return $this->fetchAll($sql, [$brand]);
    }


    public function searchProducts($q)
    {
    $sql = "SELECT
                products.*,
                categories.cat_name,
                brands.brand_name
            FROM products
            JOIN categories
                ON products.product_cat = categories.cat_id
            JOIN brands
                ON products.product_brand = brands.brand_id
            WHERE products.product_title LIKE ?
               OR products.product_keywords LIKE ?
            ORDER BY products.product_id DESC";

    $search = '%' . $q . '%';

    return $this->fetchAll(
        $sql,
        [$search, $search]
    );
    }


}   

