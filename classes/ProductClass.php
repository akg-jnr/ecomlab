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
}
