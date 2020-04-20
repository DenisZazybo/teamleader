<?php

class ProductService
{
    private static function getData()
    {
        // todo
        // the method of obtaining data is not extensible (f.e to obtain data from other sources)
        // In addition, access to the data layer must be moved to another architecture level (not a business logic layer).
        // For a more clear architecture

        // todo
        // need to add file availability check
        return json_decode(file_get_contents(__DIR__ . '/../data/products.json'), true);
    }

    public static function getItemCategoryId($id)
    {
        $foundProduct = null;

        // todo
        // incoming data (self::getData()) is not checked
        foreach(self::getData() as $product) {

            // todo
            // $product['id'] may not exist
            if($product['id'] == $id) {

                // todo
                // I assume that the loop should be interrupted by the triggering condition
                // It should help save some resources sometimes
                $foundProduct = $product;
            }
        }

        // todo
        // $foundProduct can be null and $foundProduct['category'] may by not exist
        return $foundProduct['category'];
    }

    public static function getProductName($id)
    {
        $foundProduct = null;

        // todo
        // incoming data (self::getData()) is not checked
        foreach(self::getData() as $product) {

            // todo
            // $product['id'] may not exist
            if($product['id'] == $id) {

                // todo
                // I assume that the loop should be interrupted by the triggering condition
                // It should help save some resources sometimes
                $foundProduct = $product;
            }
        }

        // todo
        // $foundProduct can be null null and $foundProduct['description'] may by not exist
        return $foundProduct['description'];
    }
}
