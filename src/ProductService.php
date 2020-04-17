<?php

class ProductService
{
    private static function getData()
    {
        return json_decode(file_get_contents(__DIR__ . '/../data/products.json'), true);
    }

    public static function getItemCategoryId($id)
    {
        $foundProduct = null;

        foreach(self::getData() as $product) {
            if($product['id'] == $id) {
                $foundProduct = $product;
            }
        }

        return $foundProduct['category'];
    }

    public static function getProductName($id)
    {
        $foundProduct = null;

        foreach(self::getData() as $product) {
            if($product['id'] == $id) {
                $foundProduct = $product;
            }
        }

        return $foundProduct['description'];
    }
}
