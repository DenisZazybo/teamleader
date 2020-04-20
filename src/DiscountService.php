<?php


class DiscountService
{
    // todo
    // also if you use PHP7+ you should use Return Type Declarations and other type hints depends on your PHP version
    public function calculateDiscounts($order)
    {
        // todo
        // the $order variable may be invalid,
        // verification of incoming parameters must be implemented

        // todo
        // passing parameters by reference complicates code readability
        // and increases the likelihood of errors when expanding the service
        $this->calculateDiscount1($order);
        $this->calculateDiscount2($order);
        $this->calculateDiscount3($order);

        return $order;
    }

    // todo
    // name of the method is unclear
    // why is calculateDiscount1?
    private function calculateDiscount1(&$order)
    {
        $customer = CustomerService::getCustomer($order);

        // todo
        // $customer can be null - it doesnt check
        // $customer["revenue"] may not exist
        if($customer["revenue"] >= 1000) {
            if(!array_key_exists("discounts", $order)) {
                $order['discounts'] = [];
            }

            $order["discounts"][] = [

                // todo
                // $order["total"] may not exist
                'amount' => $order["total"] * 0.1,
                "reason" => "High revenue customer"
            ];

            $order['total'] = $order["total"] * 0.9;
        }
    }

    // todo
    // name of the method is unclear
    // why is calculateDiscount2?
    private function calculateDiscount2(&$order)
    {
        // todo
        // $order["items"] may not exist
        foreach($order["items"] as &$item) {

            // todo
            // binding conditions to value of id is a bad idea
            // also $item['product-id'] may be not exist
            // strict comparisons should also be used
            if(2 == ProductService::getItemCategoryId($item['product-id'])) {

                // todo
                // why do we need a variable? $or
                // $order["quantity"] may not exist
                $or = $item['quantity'];

                //let's give them one extra anyways, we'll not charge it anyways...
                if ($item['quantity'] % 6 == 5) {
                    $item['quantity'] = $item['quantity'] + 1;
                    $item['total'] = $item['total'] + $item['price'];
                    $order['total'] = $order['total'] + $item['price'];
                }

                if ($item['quantity'] / 6 >= 1) {
                    if(!array_key_exists("discounts", $order)) {
                        $order['discounts'] = [];
                    }

                    $n = floor($item['quantity'] / 6);

                    $order['discounts'][] = [
                        'amount' => $item['unit-price'] * $n,
                        'reason' => 'You bought ' . $or . ' items of ' . ProductService::getProductName($item['product-id']) . ", so you get $n for free."
                    ];

                    $order['total'] = $order['total'] - $n * $item['unit-price'];
                }
            }
        }
    }

    // todo
    // name of method not clear
    // why is calculateDiscount3?
    private function calculateDiscount3(&$order)
    {
        $array = [];

        // todo
        // $order["items"] may not exist
        foreach($order['items'] as $item) {

            // todo
            // binding conditions to id is a very bad idea
            // also $item['product-id'] may be not exist
            // strict comparisons should also be used
            if (1 == ProductService::getItemCategoryId($item['product-id']))
            {
                $array[] = $item;
            }
        }

        // todo
        // $array[0]['quantity'] may be not exist
        if(count($array) >= 2 || $array[0]['quantity'] >= 2) {
            usort($array, ['DiscountService', 'sort']);

            if(!array_key_exists("discounts", $order)) {
                $order['discounts'] = [];
            }

            $order['discounts'][] = [
                'amount' => $array[0]['unit-price'] * 0.2,
                'reason' => 'You bought more than one Tool, so we give you 20% discount on the cheapest one: ' . ProductService::getProductName($array[0]['product-id']),
            ];

            $order['total'] = $order['total'] - $array[0]['unit-price'] * 0.2;
        }
    }

    // todo
    // method name can be confusing
    private static function sort($a, $b)
    {
        // todo
        // $a['unit-price'] and $b['unit-price'] may be not exist
        return $a['unit-price'] - $b['unit-price'];
    }
}
